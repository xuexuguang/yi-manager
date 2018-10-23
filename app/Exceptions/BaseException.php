<?php

namespace App\Exceptions;


/**
 * Class BaseException
 *
 * @package App\Exceptions
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-09-21 14:55:56
 */
class BaseException extends \Exception
{
    public $httpCode  = 500;
    public $errorMsg  = '服务器未知错误.';
    public $errorCode = 999;

    public function __construct($params = [])
    {
        if (! empty($params) && is_array($params)) {
            array_key_exists('httpCode', $params) && $this->httpCode = $params['httpCode'];
            array_key_exists('errorMsg', $params) && $this->errorMsg = $params['errorMsg'];
            array_key_exists('errorCode', $params) && $this->errorCode = $params['errorCode'];
        }
        return null;
    }

}