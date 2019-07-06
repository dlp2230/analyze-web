<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class PayLog extends BaseLog
{
    public static $payTypeConfig = [
        1=>[
            0=>'元宝充值',
        ],
        2=>[
            1=>'月卡',
        ],
    ];
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_type', 'CP_item_type','CP_channel','CP_money','CP_money_type','CP_game_money','CP_order','CP_channel_order']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_type', 'CP_item_type','CP_channel','CP_money','CP_money_type','CP_game_money','CP_order','CP_channel_order']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_type' => 'int',
            'CP_item_type' =>'int',
            'CP_channel' =>'int',
            'CP_money' =>'float',
            'CP_money_type' =>'string',
            'CP_game_money' =>'int',
            'CP_order' =>'string',
            'CP_channel_order' =>'string',
        ]);
    }
}