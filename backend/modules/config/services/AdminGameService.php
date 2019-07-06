<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Admin;
use common\models\AdminGame;
use common\models\AdminGroup;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class AdminGameService extends Service
{
    public function getAdminGame($uid)
    {
        $game_ids = AdminGame::findAll(['id' => $uid]);
        return ArrayHelper::getColumn($game_ids, 'game_id');
    }
}