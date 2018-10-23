<?php

namespace App\Exceptions;


use App\Tools\Code;

/**
 * Class DataNotFoundException
 *
 * @package App\Exceptions
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-03 18:30:56
 */
class DataNotFoundException extends BaseException
{
    public $httpCode  = 200;
    public $errorMsg  = '暂无数据';
    public $errorCode = Code::SUCCESS;
}