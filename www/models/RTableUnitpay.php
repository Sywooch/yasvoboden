<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "r_table_unitpay".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $sum
 * @property string $sign
 * @property string $paymentType
 * @property integer $projectId
 * @property integer $unitpayId
 * @property integer $date
 * @property integer $status
 */
class RTableUnitpay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'r_table_unitpay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'sum', 'sign', 'status'], 'required'],
            [['id_user', 'sum', 'projectId', 'unitpayId', 'date', 'status'], 'integer'],
            [['sign', 'paymentType'], 'string', 'max' => 255]
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
            'sign' => 'Sign',
            'paymentType' => 'Payment Type',
            'projectId' => 'Project ID',
            'unitpayId' => 'Unitpay ID',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }
}
