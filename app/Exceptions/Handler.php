<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * @var int 全局统一错误状态码
     */
    private $errorCode;

    /**
     * @var string 全局统一错误消息
     */
    private $errorMsg;

    /**
     * @var int 全局统一httpCode
     */
    private $httpCode;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        CategoryException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof BaseException) {
            $this->httpCode = $exception->httpCode;
            $this->errorMsg = $exception->errorMsg;
            $this->errorCode = $exception->errorCode;
        } else {
            //如果是服务器的未知错误
            if (env('APP_DEBUG')) {
                return parent::render($request, $exception);
            } else {
                $this->httpCode = 500;
                $this->errorMsg = '服务器未知错误';
                $this->errorCode = 999;
                Log::error($exception->getMessage());
            }
        }

        return [
           'status' => $this->errorCode,
           'msg'  => $this->errorMsg,
           'data' => [
               'request_url' => $request->url(),
           ]
        ];
        // return parent::render($request, $exception);
    }
}
