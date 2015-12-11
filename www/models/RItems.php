<?php

namespace app\models;

use Yii;
use app\models\RImages; 
use app\models\RPrice;
use app\models\RFields;
use app\models\FCity;
use app\models\FRegion;
use app\models\FOkrug;
use app\models\RActiveItems;
use app\models\FCategory;
use app\models\FFields;
use app\models\SBlackWord;
use app\models\User;
use app\models\RBadRecord;
use linslin\yii2\curl;

/**
 * This is the model class for table "r_items".
 *
 * @property integer $id
 * @property integer $id_parent
 * @property string $name
 * @property string $description
 * @property integer $date
 */
class RItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_items';
    }


    public static function find()
    {
        return new RItemsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_parent', 'name', 'description', 'date'], 'required'],
            [['id_parent', 'date'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_parent' => 'Id Parent',
            'name' => 'Name',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }

    public function getTimeBack()
    {
        $now = time();

        $date = $this->activeItem->start_date;
        $diff = $now - $date;

        $result["value"] = $diff;

        if ($diff <= 60)
        {
            $result["real_value"] = (int)$diff;
            $result["izmerenie"] = "сек";
        }
        elseif ($diff <= (60*60))
        {
            $result["real_value"] = (int)($diff/60);
            $result["izmerenie"] = "мин";
        }
        elseif ($diff <= (60*60*24))
        {
            $result["real_value"] = (int)($diff/(60*60));
            $result["izmerenie"] = "час";
        }
        elseif ($diff > (60*60*24))
        {
            $result["real_value"] = (int)($diff/(60*60*24));
            $result["izmerenie"] = "дн";
        }

        return $result; 
    }

    public function getImages()
    {
        $result = $this->hasMany(RImages::className(), ['id_item' => 'id']);
        if (count($result->all()) == 0)
           $result = RImages::find()->where(["id" => 1])->all();
      
       return $result;

    }

    public function getPrices() 
    {
        return $this->hasMany(RPrice::className(), ['id_item' => 'id']);
    }

    public function getFields()
    {
        return $this->hasMany(RFields::className(), ['id_item' => 'id'])
            ->leftJoin(FFields::tableName(), "f_fields.id = r_fields.id_field")
            ->orderBy('f_fields.sort, f_fields.name');
    }

    public function getCity()
    {
        return $this->hasOne(FCity::className(), ['id' => 'id_city']);
    }

    public function getActiveItem()
    {
        return $this->hasOne(RActiveItems::className(), ['id_item' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(FCategory::className(), ['id' => 'id_parent']);
    }

    public function getCatName()
    {
        $txt = $this->category->name;

        $parent = $this->category;

        while ($parent->parent)
        {
            $parent = $parent->parent;
            $txt = $parent->name." &#8658; ".$txt;
        }

        return $txt;
    }

    public function getBadRecord()
    {
        return $this->hasOne(RBadRecord::className(), ['id_item' => 'id']);
    }

    public function getGeo()
    {
        if ($this->id_city != "")
            return $this->city->name; 
    }

    public function getIsStatus()
    {
        if ($this->activeItem)
            return true;
        else
            return false;
    }

    public function getIsStatusText()
    {
        if ($this->isStatus)
            return "Деактивировать";
        else
            return "Активировать";
    }

    public function beforeDelete()
    {
        $user = Yii::$app->user->identity;
        if (parent::beforeDelete() and (($this->id_user == $user->id) or ($user->role == 777) or ($user->role == 888))) {
            
            foreach ($this->fields as $field)
                $field->delete();
            
            foreach ($this->images as $image)
                $image->delete();

            foreach ($this->prices as $price)
                $price->delete(); 

            if ($this->isStatus)
                $this->activeItem->delete();

            if ($this->badRecord)
                $this->badRecord->delete();
                
            return true;
        } else {
            return false;
        }
    }

    public function disabled()
    {
        $this->activeItem->delete();
    }

    public function enabled()
    {
        if ($this->validRecord())
        {
            $user = $user = Yii::$app->user->identity;
            $user->scenario = "money";
            $session = Yii::$app->session;

            if (isset($this->category->priceCategory->price))
                $price = $this->category->priceCategory->price;
            else
                $price = 0;

            if ($user->money >= $price)
            {
                $activeItem = new RActiveItems(); 

                $activeItem->id_item = $this->id;
                
                if (isset($this->category->priceCategory->time))
                    $dt_time = $this->category->priceCategory->time;
                else
                    $dt_time = 0;

                $activeItem->date = time() + $dt_time;
                $activeItem->start_date = time();
                $activeItem->save();

                $user->minusMoney($price);
            }
            else
                $session->setFlash('error',"Недостаточно средств на счете!");
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function validRecord()
    {
        $SBlackWord = SBlackWord::find()->all();

        $session = Yii::$app->session;

        foreach ($SBlackWord as $word)
        {
            if ($this->searchWord($word->value))
                $arr_word[] = $word->value;
        }

        if ((isset($arr_word)) and (count($arr_word) > 0))
        {
            $msg = "Ошибка в контенте предложения! Присутствуют запрещеные слова: ";
            foreach ($arr_word as $word)
                $msg .= $word." ";

            $session->setFlash('error', $msg);

            return false;
        } 
        
        return true;
    }

    public function searchWord($word)
    {

        if (stripos(mb_strtolower($this->name, "UTF-8"), mb_strtolower($word, "UTF-8")) )
            return true;

        if (stripos(mb_strtolower($this->description, "UTF-8"), mb_strtolower($word, "UTF-8")))
            return true;

        if ($this->fields)
        {
            foreach ($this->fields as $field) 
                $arr_field[] = $field->val;

            if (isset($arr_field) and array_search(mb_strtolower($word, "UTF-8"), $arr_field))
                return true;
        } 

        return false;

    }

    public function getEndTime()
    {
        if ($this->activeItem)
        {
            $timeItem = $this->activeItem->date;
            $timeNow = time();

            $resTime = $timeItem - $timeNow;
            $resText = (int)($resTime/60);

            return "Осталось ".$resText." минут";
        }
        else
        {
            return "";
        }
    }

    public function isShowBtn($count)
    {
        $c_str = strlen($this->description);

        if ($c_str >= $count)
            return true;
        else
            return false;
    }

    public function sendSms()
    {
        $result = "";

        $user = Yii::$app->user->identity;

        if ($this->id_user != $user->id)
            return false;

        if ($this->sms == 1)
        {
            $url = 'https://pbc.pbsol.ru:1443/pbc.php';
            $curl = new curl\Curl();
            $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
           
            $phone = $this->user->phone;

            switch (strlen($phone))
            {
                case 12:
                    $phone = substr($phone, 1);
                    break;
                case 11:
                    $phone = "7".substr($phone, 1);
                    break;
                case 10:
                    $phone = "7".substr($phone, 0);
                    break;
                default:
                    $result = "200";
                    break;
            }

            $msg = "Yasv ".$this->id;

            $params = [
                'product' => 'sms_yasv',
                'password' => 'Acn752Mnt',
                'phone' => $phone,
                'price' => '1000',
                'msg' => $msg
            ];

            $url .= '?' . http_build_query($params);

            $result = $curl->get($url);

            if ($result != "100")
            {
                $this->sms = 2;
                $this->save();
            }
            
        }
        else
            $result = false;

        return $result;

    }

}


class RItemsQuery extends \yii\db\ActiveQuery
{
    public function city($geo)
    {
        if ($geo->getArrayCity())
            return $this->andWhere(["id_city" => $geo->getArrayCity()]);
        else
            return $this;
    }

    public function isActive()
    {
        return $this->joinWith('activeItem')->andWhere('`r_active_items`.`id_item` = `r_items`.`id`')->orderBy('start_date desc');
    }
}