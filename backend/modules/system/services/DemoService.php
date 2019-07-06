<?php
namespace backend\modules\system\services;

use common\collections\Demo;
use common\helpers\MongoHelper;
use common\libraries\base\Service;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016/3/4
 * Time: 10:56
 */
class DemoService extends Service
{
    public function mysqlInsertDemo()
    {
        $demo = new \common\models\Demo();
        $demo->name = 'test';
        $demo->sex = \common\models\Demo::SEX_GIRL;
        $demo->save();
    }

    public function mysqlReadDemo()
    {
        $data = \common\models\Demo::find()
            ->asArray()
            ->one();
        pe($data);
        $data = \common\models\Demo::find()
            ->count();
        pe($data);
    }

    public function mongoInsertDemo()
    {
        //修改mongo链接库为game_5656
        MongoHelper::setMongo('5656');
        //ee($mongo);
        $demo = new Demo();
        $demo->name = 'test';
        $demo->sex = DEMO::SEX_GIRL;
        $demo->save();
    }

    public function mongoReadDemo()
    {
        //修改mongo链接库为game_5656
        MongoHelper::setMongo('5656');
        //ee($mongo);
        $data = Demo::find()
            ->asArray()
            ->one();
        pe($data);
        $data = Demo::find()
            ->count();
        pe($data);
    }
}