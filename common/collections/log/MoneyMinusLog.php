<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class MoneyMinusLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_type', 'CP_note','CP_num','CP_true_num','CP_false_num']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_type', 'CP_note','CP_num','CP_true_num','CP_false_num']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_type' => 'int',
            'CP_note' =>'string',
            'CP_num' =>'int',
            'CP_true_num' =>'int',
            'CP_false_num' =>'int',
         ]);
    }
}






