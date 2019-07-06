<?php

namespace common\collections\log;

use common\collections\Log as BaseLog;

class LoginLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_login_type', 'CP_online_time']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_login_type', 'CP_online_time']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_login_type' => 'int',
            'CP_online_time' =>'int',
        ]);
    }
}