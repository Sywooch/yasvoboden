<?php

namespace app\models;

use Yii;
use app\models\SType;
use yii\helpers\ArrayHelper; 
use yii\helpers\Url;
use yii\helpers\Html;
/**
 * This is the model class for table "f_fields".
 *
 * @property integer $id
 * @property integer $id_category
 * @property string $name
 * @property integer $type
 * @property string $unit
 */
class FFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'name', 'type'], 'required'], 
            [['id_category', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['unit'], 'string', 'max' => 20],
            [['sort'], 'integer'],
            ['sort', 'default', 'value' => 500]
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
                
            if ($this->rFields)
                foreach($this->rFields as $rfield)
                    $rfield->delete();

            if ($this->sSelect)
                foreach($this->sSelect as $select)
                    $select->delete();
                
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_category' => 'Id Category',
            'name' => 'Название',
            'type' => 'Тип',
            'unit' => 'Единица измерения',
            'sort' => 'Сортировка'
        ];
    }

    public function getAdminUrl()
    {
        switch ($this->typeLink->name) 
        {
            case 'select':
                $url = Url::toRoute(['/cabinet/field', 'id' => $this->id]);
                break;
            
            default:
                $url = "#";
                break;
        }

        return $url;
    }

    public function getTypeLink()
    {
        return $this->hasOne(SType::className(), ['id' => 'type']);
    }

    public function getTypeList()
    {
        $models = SType::find()->asArray()->all();

        return ArrayHelper::map($models, 'id', 'rus_name');
    }

    public function getRFields()
    {
        return $this->hasMany(RFields::className(), ['id_field' => 'id']);
    }

    public function getSSelect()
    {
        return $this->hasMany(SSelect::className(), ['id_field' => 'id']);
    }

    public function getParentCategory()
    {
        return $this->hasOne(FCategory::className(), ['id' => 'id_category']);
    }

    public function getEditInput($model, $name, $options = [])
    {
        $field_name = $name;
        
        switch ($this->typeLink->name) 
        {
            case 'select':
                $items = $this->sSelect;
                $items = ArrayHelper::map($items, 'id', 'value');
                $html = Html::activeDropDownList($model, $field_name, $items, $options);
                break;

            case 'yandex_map':
                $html = $this->yandexMap($model, $field_name, $options);
                break;
            
            default:
                $html = Html::activeTextInput($model, $field_name, $options);
                break;
        }

        return $html;
    }

    private function yandexMap($model, $field_name, $options)
    {
        $txt =  Html::beginTag("div");

        $id_map = 'map'.$this->id;
        $id_field = 'field'.$this->id;


        $txt .= Html::beginTag('div', ['id' => $id_map, 'style' => 'height: 400px;']);

        $txt .= Html::endTag("div");
 
        $options["id"] = $id_field;

        $txt .= Html::activeHiddenInput($model, $field_name, $options);

        $txt .= Html::endTag("div");

        $script = "
            ymaps.ready(init);
            var myMap;

            function init(){     
                
                var coord = $('#".$id_field."').val();
                coord = coord.split(',');
                

                if (coord.length == 1)
                {
                    
                    coord = [55.76, 37.64];
                }
                else
                    var dPlacemark = new ymaps.Placemark(coord);
                

                myMap = new ymaps.Map('".$id_map."', {
                    center: coord,
                    zoom: 7
                });

                if (dPlacemark)
                    myMap.geoObjects.add(dPlacemark);

                myMap.events.add('click', function (e) {
                    var coords = e.get('coords');
                    

                    var eMap = e.get('target');

                    x = coords[0].toPrecision(8);
                    y = coords[1].toPrecision(8);

                    $('#".$id_field."').val(x+', '+y);

                    var myPlacemark = new ymaps.Placemark([x, y]);
                    eMap.geoObjects.removeAll();
                    eMap.geoObjects.add(myPlacemark);
                });
            };
        ";

        $txt .= Html::script($script);

        $txt .= Html::jsFile(Url::to('@web/js/yandex_map.js'));

        return $txt;
    }
}
