<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class GoldMinusLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_type', 'CP_note','CP_num']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_type', 'CP_note','CP_num']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_type' => 'int',
            'CP_note' =>'string',
            'CP_num' =>'int',
        ]);
    }
}

