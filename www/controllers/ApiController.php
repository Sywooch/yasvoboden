<?php

namespace app\controllers;

use Yii;
use app\models\RTableUnitpay;
use app\models\User;
use app\models\STypeMoney;

class ApiController extends CController
{
    public function behaviors()
    {
        return [
            
        ];
    }


   public function actionUnit()
   {
        $get = Yii::$app->request->get();

        
        $result = "";

        if ($get["method"] == "check")
            $result = $this->unitCheck($get["params"]);
        elseif ($get["method"] == "pay")
            $result = $this->unitPay($get["params"]);


        return json_encode($result);
   }

   private function unitCheck($param)
   {
        $id_user = $param["account"];
        
        $user = User::findOne($id_user);

        if ($user)
        {
            $sum = $param["sum"];
        
            $unitpayId = $param["unitpayId"];

            $RTableUnitpay = RTableUnitpay::findOne(['unitpayId' => $unitpayId]);

            if (!$RTableUnitpay)
                $RTableUnitpay = new RTableUnitpay();

            
            $RTableUnitpay->id_user = $id_user;
            $RTableUnitpay->sum = $param["sum"];
            $RTableUnitpay->paymentType = $param["paymentType"];
            $RTableUnitpay->projectId = $param["projectId"];
            $RTableUnitpay->unitpayId = $param["unitpayId"];
            $RTableUnitpay->date = strtotime($param["date"]);
            $RTableUnitpay->sign = $param["sign"];
            $RTableUnitpay->status = 1;
            $RTableUnitpay->save();

            $result["result"]["message"] = "Проверка платежа Check прошла успешно!";
        }
         else
                $result["error"]["message"] = "Не выполнялся данный запрос пользователем!";
        

        //$result["param"] = $param;

        return $result;
   }

   private function unitPay($param)
   {
        $unitpayId = $param["unitpayId"];

        $RTableUnitpay = RTableUnitpay::findOne(['unitpayId' => $unitpayId]);

        if ($RTableUnitpay)
        {
            if ($RTableUnitpay->status == 1)
            {
                $id_user = $param["account"];
                $user = User::findOne($id_user);
                $sum = $param["sum"];

                $user->scenario = "money";

                $STypeMoney = STypeMoney::findOne(['name' => $param['paymentType']]);

                if ($STypeMoney)
                    $id_type = $STypeMoney->id;
                else
                    $id_type = 12;

                $user->addMoney($sum, $id_type); 

                $RTableUnitpay->status = 2;
                $RTableUnitpay->save();

                $result["result"]["message"] = "Платеж прошел успешно! Спасибо!";
            }
            else
                $result["error"]["message"] = "По данному чеку уже были начисления!";
        }
        else
            $result["error"]["message"] = "Не выполнялся данный запрос пользователем!";

        return $result;
   }

}
