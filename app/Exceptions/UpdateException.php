<?php

namespace App\Exceptions;


use App\Tools\Code;

/**
 * Class UpdateException
 *
 * @package App\Exceptions
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-23 19:17:56
 */
class UpdateException extends BaseException
{
    public $httpCode  = 200;
    public $errorMsg  = '更新数据错误.';
    public $errorCode = Code::UPDATE_ERR;
}