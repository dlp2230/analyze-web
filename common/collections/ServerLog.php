<?php

namespace common\collections;

use common\libraries\base\MongoActiveRecord;

class ServerLog extends MongoActiveRecord
{
    //behavior
    const SERVER = 1;


    public static function collectionName()
    {
        return 'server_log';
    }

    public function attributes()
    {
        return ['_id', 'behavior', 'game_id', 'server_id', 'oserver_id', 'timestamp'];
    }
    protected static function transformRules()
    {
        return [
            '_id' => 'string',
            'behavior' => 'int',
            'game_id' => 'int',
            'server_id' => 'int',
            'oserver_id' => 'int',
            'timestamp' => 'int',
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['behavior', 'game_id', 'server_id', 'oserver_id', 'timestamp'],
        ];
    }
}