<?php

namespace App\Exceptions;


use App\Tools\Code;

/**
 * Class addException
 *
 * @package App\Exceptions
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-03 18:44:56
 */
class addException extends BaseException
{
    public $httpCode  = 200;
    public $errorMsg  = '添加数据错误.';
    public $errorCode = Code::INSERT_ERR;
}