<?php
namespace backend\modules\overview\service;

use common\collections\ServerLog;
use common\collections\serverLog\ServerServerLog;
use common\helpers\MongoHelper;
use common\libraries\base\Service;


class RealService extends Service
{

    /**
     * 查询新增角色数量
     */
    public function getRoleOnline($game_id, $server_id, $sts,$ets)
    {
        $data = [];
        MongoHelper::setMongo($game_id);
        $where = [
            'behavior' => ServerServerLog::SERVER,
            'server_id' => intval($server_id),
        ];
        $where = ServerServerLog::transArr($where);

        $where['timestamp']['$gte'] = ServerServerLog::transKey('timestamp', $sts);
        $where['timestamp']['$lt'] =  ServerServerLog::transKey('timestamp', $ets);
        $data = ServerServerLog::find()
            ->where($where)
            ->orderBy('timestamp asc')
            ->asArray()
            ->all();
       return $data;

    }




}