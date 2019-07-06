<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class RegisterLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_channel_id', 'CP_cps_id','CP_role_id','CP_create_time']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_channel_id', 'CP_cps_id','CP_role_id','CP_create_time']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_channel_id'=>'int',
            'CP_cps_id'=>'int',
            'CP_role_id'=>'string',
            'CP_create_time'=>'int',
        ]);
    }

}