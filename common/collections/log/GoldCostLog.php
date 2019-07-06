<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class GoldCostLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_type', 'CP_object','CP_count','CP_price']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_type', 'CP_object','CP_count','CP_price']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_type' => 'int',
            'CP_object' =>'int',
            'CP_count' =>'int',
            'CP_price' =>'int',
        ]);
    }
}

