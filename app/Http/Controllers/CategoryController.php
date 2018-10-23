<?php

namespace App\Http\Controllers;


use App\Exceptions\addException;
use App\Exceptions\CategoryException;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\UpdateException;
use App\Models\Category;
use App\Tools\Code;
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
        $this->validate($request, [
            'name' => 'required|unique:category|max:20',
            'desc' => 'nullable|max:20',
        ]);

        $category = new Category();
        $category->name = $request->get('name');
        $category->desc = $request->get('desc', '');

        if (! $category->save()) {
            throw new addException();
        }

        return responseJson(Code::SUCCESS);
    }

    public function getAllCategories()
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }

        return $categories;
    }

    public function updateCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'name' => 'required|unique:category|max:20',
            'desc' => 'nullable|max:20',
        ]);

        $category = Category::find($request->get('id'));

        if (empty($category)) {
            throw new DataNotFoundException();
        }

        $category->name = $request->get('name');
        $category->desc = $request->get('desc', '');
        if (! $category->save()) {
            throw new UpdateException();
        }

        return responseJson(Code::SUCCESS);
    }

    public function deleteCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $category = Category::find($request->get('id'));

        if (empty($category)) {
            throw new DataNotFoundException();
        }

        if (! $category->delete()) {
            throw new UpdateException();
        }

        return responseJson(Code::SUCCESS);
    }

}