<?php

namespace App\Exceptions;


/**
 * Class CategoryException
 *
 * @package App\Exceptions
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-23 16:35:56
 */
class CategoryException extends BaseException
{
    public $httpCode  = 404;
    public $errorMsg  = '未找到分类.';
    public $errorCode = 2000;

}