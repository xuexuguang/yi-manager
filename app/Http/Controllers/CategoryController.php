<?php

namespace App\Http\Controllers;


use App\Exceptions\CategoryException;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-23 16:16:56
 */
class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:category|max:20',
            'desc' => 'nullable|max:20',
        ]);

        $category = new Category();
        $category->name = $request->get('name');
        $category->desc = $request->get('desc', '');
        $category->save();
    }

    public function getAllCategories()
    {
        $categories= Category::all();
        if ($categories->isEmpty()){
            throw new CategoryException();
        }

        return $categories;
    }

}