<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Admin;
use common\models\AdminGame;
use common\models\AdminGroup;


/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/11/4
 * Time: 18:03
 */
class AdminService extends Service
{
    public function getList($start, $length, $where)
    {
        return Admin::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Admin::find()->where($where)->count();
    }

    static function resetPasswd($where)
    {
        $passwd = self::createPassword();
        if (Admin::updateAll(['password' => md5($passwd)], $where)) {
            return $passwd;
        }
        return false;
    }

    /**
     * 生成密码
     */
    static function createPassword()
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $len = 8;
        $strLen = strlen($chars) - 1;
        $password = '';
        for ($i = 0; $i < $len; $i++) {
            $password .= $chars[mt_rand(0, $strLen)];
        }
        return $password;
    }

    public function add($data)
    {
        $admin = new Admin();
        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->ag_id = $data['ag_id'];
        $admin->mobile = $data['mobile'];
        $admin->status = $data['status'];
        $password = self::createPassword();
        $admin->password = md5($password);
        $admin->insert();
        //绑定游戏

        foreach ($data['game_ids'] as $game_id) {
            $adminGame = new AdminGame();
            $adminGame->id = $admin->id;
            $adminGame->game_id = $game_id;
            $adminGame->save();
        }
        return $password;
    }

    public function batchupd($id,$game_id){
        AdminGame::deleteAll(['in','id',$id]);
        if(!empty($game_id)) {
            foreach ($id as $value) {
                foreach ($game_id as $game_ids) {
                    $adminGame = new AdminGame();
                    $adminGame->id = $value;
                    $adminGame->game_id = $game_ids;
                    $adminGame->save();
                }
            }
        }
        return true;
    }

    public function upd($param, $condition)
    {
        AdminGame::deleteAll($condition);
        foreach ($param['game_ids'] as $game_id) {
            $adminGame = new AdminGame();
            $adminGame->id = $condition['id'];
            $adminGame->game_id = $game_id;
            $adminGame->save();
        }
        unset($param['game_ids']);
        Admin::updateAll($param, $condition);
    }
}