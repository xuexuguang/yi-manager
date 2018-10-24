<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'category'], function () use ($router) {
    // 分类列表
    $router->get('all', 'CategoryController@getAllCategories');

    // 添加分类
    $router->post('create', 'CategoryController@createCategory');

    // 删除分类
    $router->post('delete', 'CategoryController@deleteCategory');

    // 修改分类
    $router->post('update', 'CategoryController@updateCategory');
});


$router->group(['prefix' => 'clothes'], function () use ($router) {
    // 衣物列表
    $router->get('all', 'ClothesController@getAllClothes');

    // 添加衣物
    $router->post('create', 'ClothesController@createClothes');

    // 删除衣物
    $router->post('delete', 'ClothesController@deleteClothes');

    // 修改衣物
    $router->post('update', 'ClothesController@updateClothes');
});


