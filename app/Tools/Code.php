<?php

namespace App\Tools;


/**
 * Class Code 状态码
 *   为了维护方便，状态码与错误消息统一再此处进行映射与定义处理
 *   请使用多行注释的格式，注释code码，方便后期脚本自动化处理
 *   msg不同类型,使用两个空格进行分割
 *
 * @package App\Tools
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-09-21 14:08:56
 */
class Code
{

    /**
     * 请求成功
     */
    const SUCCESS = 0;

    // +----------------------------------------------------------------------
    // | 1xxx开头为通用错误
    // +----------------------------------------------------------------------

    /**
     * 通用错误
     */
    const NOT_FOUND = 1000;

    /**
     * 参数错误
     */
    const PARAMS_ERR = 1001;

    /**
     *  数据插入错误
     */
    const INSERT_ERR = 1002;

    /*
    * 更新数据失败
    */
    const UPDATE_ERR = 1003;

    /*
    * 删除数据失败
    */
    const DELETE_ERR = 1004;

    /*
      * 数据存在重复
    */
    const DUPLICATE_ERR = 1005;


    public static $MSG = [
        self::SUCCESS => '请求成功',

        self::NOT_FOUND => '暂无数据',
        self::PARAMS_ERR => '参数错误',
        self::INSERT_ERR => '插入数据失败',
        self::UPDATE_ERR => '更新数据失败',
        self::DELETE_ERR => '删除数据失败',
        self::DUPLICATE_ERR => '数据存在重复',
    ];
}