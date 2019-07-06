<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Channel;
use common\models\Server;
use common\models\ServerChannel;

//use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class ServerService extends Service
{

    public function getList($start, $length, $where)
    {
        return Server::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Server::find()->where($where)->count();
    }


    public function addServerChannel($sid, $channel_ids)
    {
        //先删除原来有的
        $this->delSeverChannel($sid);
        foreach ($channel_ids as $channel_id) {
            $severChannel = new ServerChannel();
            $severChannel->sid = $sid;
            $severChannel->channel_id = $channel_id;
            $severChannel->save();
        }
    }

    public function delSeverChannel($sid)
    {
        ServerChannel::deleteAll(['sid' => $sid]);
    }

    public function getServerChannelList($sid)
    {
        $list = ServerChannel::find()->where(['sid' => $sid])->asArray()->all();
        return array_column($list, 'channel_id');
    }

    //1=>安卓专服2=>IOS专服3=>安卓混服4=>安卓越狱混服5=>安卓IOS混服

    public function getServerType($channelArr)
    {
        $type = Channel::find()->select('type')->where(['in', 'channel_id', $channelArr])->asArray()->all();
        $type = array_column($type, 'type');
        $num = count($type);
        if ($num == 1) {
            //安卓专服或者 IOS专服
            $num = count($type);
            if ($num == 1) {
                if (in_array(Channel::ANDROID, $type)) {
                    return Server::SERVER_TYPE_ANDROID;
                } else if (in_array(Channel::IOS, $type)) {
                    return Server::SERVER_TYPE_IOS;
                }
            }
        }
        else {
                //混服的情况
                $numDif = count(array_unique($type));
                if ($numDif == 1 && in_array(Channel::ANDROID, $type)) {
                    return Server::SERVER_TYPE_ANDROID_S;
                } else if ($numDif == 2) {
                    if (!array_diff([Channel::ANDROID, Channel::IOS_YUE], $type)) {
                        return Server::SERVER_TYPE_ANDROID_YUE;
                    } else if (!array_diff([Channel::ANDROID, Channel::IOS], $type)) {
                        $count_value = array_count_values($type);
                        //排除多个IOS服的情况
                        if ($count_value[Channel::IOS] == 1) {
                            return Server::SERVER_TYPE_ANDROID_IOS;
                        }
                    }
                }
            }
            return false;
    }

    public function batchupd($server_id,$channel_id){
        if(!empty($channel_id)&&!empty($server_id)) {
            ServerChannel::deleteAll(['in','sid',$server_id]);
            foreach ($server_id as $value) {
                foreach ($channel_id as $id) {
                    $adminGame = new ServerChannel();
                    $adminGame->sid = $value;
                    $adminGame->channel_id = $id;
                    $adminGame->save();
                }
            }
        }
        return true;
    }
}