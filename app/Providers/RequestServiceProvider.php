<?php

namespace App\Providers;

use App\Http\Requests\Request as FormRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class RequestServiceProvider
 *
 * @package App\Providers
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-24 11:30:56
 */
class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configureFormRequests();
    }

    protected function configureFormRequests()
    {
        $this->app->afterResolving(function (ValidatesWhenResolved $resolved) {
            $resolved->validate();
        });

        $this->app->resolving(function (FormRequest $request, $app) {
            $this->initializeRequest($request, $app['request']);
        });
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  \App\Http\Requests\FormRequest            $form
     * @param  \Symfony\Component\HttpFoundation\Request $current
     * @return void
     */
    protected function initializeRequest(FormRequest $form, Request $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $form->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );

        $form->setContainer($this->app);

    }
}