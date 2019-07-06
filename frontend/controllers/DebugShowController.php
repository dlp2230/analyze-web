<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\service\DebugService;
use frontend\service\ConfigService;
use common\collections\Log;

class DebugShowController extends Controller
{
    public function actionIndex()
    {
        $behavior_type = ConfigService::$behavior_type;
        if (Yii::$app->request->get()) {
            $game_id = Yii::$app->request->get('game_id');
            $server_id = Yii::$app->request->get('server_id');
            $role_id = Yii::$app->request->get('role_id');
            $behavior = Yii::$app->request->get('type');
            switch($behavior){
                case 1; $view = $this->register($game_id,$server_id,$role_id,$behavior); break;
                case 2: $view = $this->login($game_id,$server_id,$role_id,$behavior); break;
                case 3: $view = $this->pay($game_id,$server_id,$role_id,$behavior); break;
                case 4: $view = $this->moneyAdd($game_id,$server_id,$role_id,$behavior); break;
                case 5: $view = $this->moneyCost($game_id,$server_id,$role_id,$behavior); break;
                case 6: $view = $this->moneyMinus($game_id,$server_id,$role_id,$behavior); break;
                case 7: $view = $this->goldAdd($game_id,$server_id,$role_id,$behavior); break;
                case 8: $view = $this->goldCost($game_id,$server_id,$role_id,$behavior); break;
                case 9: $view = $this->goldMinus($game_id,$server_id,$role_id,$behavior); break;
                default: break;
            }
            return $view;

        } else {
            return $this->render('index',['behavior_type'=>$behavior_type]);
        }

    }
    //注册
    private function register($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getRegisterData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('register-ajax',['resultArr'=>$data]);
    }
   //上下线
    private function login($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getLogingData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
           $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('login-ajax',['resultArr'=>$data]);
    }
    //充值加币
    private function pay($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getPayData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('pay-ajax',['resultArr'=>$data]);
    }
    //非充值加币
    private function moneyAdd($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getMoneyAddData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('moneyadd-ajax',['resultArr'=>$data]);
    }
    //消费
    private function moneyCost($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getMoneyCostData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('moneycost-ajax',['resultArr'=>$data]);
    }
    //非正常扣除
    private function moneyMinus($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getMoneyMinusData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('moneycost-ajax',['resultArr'=>$data]);
    }
    //元宝 加币
    private function goldAdd($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getGoldAddData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('goldadd-ajax',['resultArr'=>$data]);
    }
    // 金币-消费
    private function goldCost($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getGoldCostData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('goldcost-ajax',['resultArr'=>$data]);
    }
    //金币 非正常扣除
    private function goldMinus($game_id,$server_id,$role_id,$behavior)
    {
        $data = DebugService::getInstance()->getGoldMinusData($game_id,$server_id,$role_id,$behavior);
        if(!empty($data))
            $data =  $this->getParamConfig($data,$behavior);
        return $this->renderAjax('goldminus-ajax',['resultArr'=>$data]);
    }

    private function getParamConfig($data,$behavior = 1)
    {
        $fieldConfig = ConfigService::getInstance()->fieldArr($behavior);
        $fieldMap = ConfigService::getInstance()->fieldMap($behavior);
        $example = ConfigService::getInstance()->example($behavior);
        $verif = ConfigService::getInstance()->verif($behavior);
        $data = array($data,array_keys($fieldConfig),$fieldMap,$example,$verif);
        return $data;
    }
}
