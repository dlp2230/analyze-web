<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Game;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class GameService extends Service
{
    public function getList($start, $length, $where)
    {
        return Game::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Game::find()->where($where)->count();
    }

    static function getGameList(){
         return ArrayHelper::map(Game::find()->select(['game_id', 'name'])->asArray()->all(), 'game_id', 'name');
    }
}