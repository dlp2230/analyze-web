<?php
namespace backend\modules\config\services;

use common\libraries\base\Service;
use common\models\Phatform;
use yii\helpers\ArrayHelper;


class PhatformService extends Service
{
    public function getList($start, $length, $where)
    {
        return Phatform::find()->where($where)->limit($length)->offset($start)->all();
    }

    public function getListCount($where)
    {
        return Phatform::find()->where($where)->count();
    }


}