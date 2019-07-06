<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class MoneyCostLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_type', 'CP_object','CP_count','CP_price','CP_true_num','CP_false_num']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_type', 'CP_object','CP_count','CP_price','CP_true_num','CP_false_num']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_type' => 'int',
            'CP_object' =>'int',
            'CP_count' =>'int',
            'CP_price' =>'int',
            'CP_true_num' =>'int',
            'CP_false_num' =>'int',

        ]);
    }
}

