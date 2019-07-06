<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Channel;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class ChannelService extends Service
{
    public function getList($start, $length, $where)
    {
        return Channel::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Channel::find()->where($where)->count();
    }

    static function getChannelList(){
        return ArrayHelper::map(Channel::find()->select(['channel_id', 'name'])->asArray()->all(), 'channel_id', 'name');
    }
}