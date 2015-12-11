<?php

namespace app\models;

use Yii;
use app\models\SOperationsMoney;
use app\models\SStatusMoney;
use app\models\STypeMoney;

/**
 * This is the model class for table "r_money_history".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $sum
 * @property integer $operation
 * @property integer $status
 */
class RMoneyHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_money_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'sum', 'operation', 'status'], 'required'],
            [['id_user', 'sum', 'operation', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'sum' => 'Sum',
            'operation' => 'Operation',
            'status' => 'Status',
        ];
    }

    public function getDateTextDMY()
    {
        $date = date("d.m.Y", $this->date);

        return $date;
    } 

    public function getDateTextHI()
    {
        $date = date("H:i", $this->date);

        return $date;
    }

    public function getOperationT()
    {
        return $this->hasOne(SOperationsMoney::className(), ['id' => 'operation']);
    }


    public function getTypeMoney()
    {
        return $this->hasOne(STypeMoney::className(), ['id' => 'id_type']);
    }

    public function getSumText()
    {
        if ($this->operation == 1)
            return "+ ".number_format($this->sum, 2, ',', ' ' );
        else
            return "- ".number_format($this->sum, 2, ',', ' ' );

    }

    public function getStatusT()
    {
        return $this->hasOne(SStatusMoney::className(), ['id' => 'status']);
    }



}
