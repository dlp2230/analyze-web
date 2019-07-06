<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\CacheDayLog;
use common\models\CacheGoldCost;
use common\models\CacheMoneyCost;
use common\models\CacheRecharge;
use common\models\CacheRetainedDevice;
use common\models\CacheRetainedRole;
use common\models\CacheChannelDayLog;
use common\helpers\MongoHelper;
use common\collections\Log;
use common\collections\ServerLog;
use yii\base\Exception;


/**
 * Created by PhpStorm.
 * User: dlx
 * Date: 2016/08/08
 * Time: 10:33
 */
class ClearService extends Service
{
    /*
     *清档操作
     * **/
    public function clearFile($game_id,$server_id,$open_server_time){
        if(!isset($game_id) || !isset($server_id) || !isset($open_server_time))
            return false;

        try{
            //--mongo
            MongoHelper::setMongo($game_id);
            $where = [
                'game_id'    =>   intval($game_id),
                'server_id'  =>   intval($server_id)
            ];
            $where['timestamp']['$lte'] =  intval(strtotime($open_server_time));
            Log::getCollection()->remove($where);
            ServerLog::getCollection()->remove($where);
            unset($where['timestamp']);
            $where['ts'] =  ['<=','ts',strtotime($open_server_time)];
            //--mysql-
            CacheDayLog::deleteAll($where);
            CacheGoldCost::deleteAll($where);
            CacheMoneyCost::deleteAll($where);
            CacheRecharge::deleteAll($where);
            CacheRetainedRole::deleteAll($where);
            CacheRetainedDevice::deleteAll($where);
            CacheChannelDayLog::deleteAll($where);
        }catch(Exception $e){
            return false;
        }
        return true;
    }
}