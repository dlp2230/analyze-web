<?php
namespace backend\config;

use common\libraries\base\Object;

/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2015/12/1
 * Time: 10:52
 */
class CacheKey extends Object
{
    /**首字母表示类型
     * H->Hash HK->Hash Key
     * L->list
     * S->string
     * ST->Set
     */
    //用户模块

    //Phatform-Info
    const H_PhatformKey_PhatformInfo = 'Phatform:Game_id#Phatform';
    const H_CdkeySetting_GameIdPrefix = 'CdkeySetting:Game_id$Prefix#CdkeySetting';



    /**
     * 格式如下
     *
     * const格式
     * H_key_value
     * 例如:用户名称跟用户id的缓存
     * H_Username_Uid
     * 例如:账户密码跟用户id的缓存
     * H_UsernamePassword_Uid
     *
     * 值格式
     * 类别名:key#value
     * 例如:用户名称跟用户id的缓存
     * User:Username#Uid
     * 例如:账户密码跟用户id的缓存,多个查询条件用$做拼接
     * User:Username$Password#Uid
     */
}