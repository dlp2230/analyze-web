<?php

namespace common\collections\serverLog;

use common\collections\ServerLog as BaseLog;

class ServerServerLog extends BaseLog
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'CP_sever_timestamp', 'CP_online_count']);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'CP_sever_timestamp', 'CP_online_count']);
    }

    protected static function transformRules()
    {
        return array_merge(parent::transformRules(),[
            'CP_sever_timestamp' => 'int',
            'CP_online_count' =>'int',
        ]);
    }
}