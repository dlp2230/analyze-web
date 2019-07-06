<?php
namespace backend\modules\config\controllers;


//use backend\modules\config\services\GameService;
use Yii;
use backend\libraries\base\Controller;
use common\models\Game;

/**
 * Perm controller
 */
class GameController extends Controller
{

    public function actionList()
    {
        $list = $this->quickDataAndPage('backend\modules\config\services\GameService',
            'getList', ['disNums' => 20]);
        return $this->render('list', ['list' => $list]);
    }

    public function actionAdd()
    {
        if (Yii::$app->request->isGet) {
            return $this->renderPartial('addOrUpd.php');
        } else {
            $game = new Game();
            $game['game_id'] = Yii::$app->request->post('game_id');
            $game['name'] = Yii::$app->request->post('name');
            $game->insert();
            return $this->renderJson(['ok' => 1, 'msg' => '添加成功!']);
        }
    }

    public function actionDel()
    {
        $game_id = Yii::$app->request->get('game_id');
        Game::deleteAll(['game_id' => $game_id]);
        return $this->renderJson(['ok' => 1, 'msg' => '删除成功!']);
    }

    public function actionUpd()
    {
        if (Yii::$app->request->isGet) {

            $game_id = Yii::$app->request->get('game_id');
            $type = 'edit';
            $item = Game::findOne(['game_id' => $game_id]);
            return $this->renderPartial('addOrUpd', ['type' => $type, 'item' => $item]);

        } else {

            $condtion['game_id'] = Yii::$app->request->post('oid');
            $param['name'] = Yii::$app->request->post('name');
            $param['game_id'] = Yii::$app->request->post('game_id');
            Game::updateAll($param, $condtion);
            return $this->renderJson(['ok' => 1, 'msg' => '修改成功!']);
        }
    }
}
