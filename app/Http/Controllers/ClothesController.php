<?php

namespace App\Http\Controllers;


use App\Exceptions\addException;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\UpdateException;
use App\Models\Clothes;
use App\Tools\Code;
use Illuminate\Http\Request;

/**
 * Class ClothesController.php
 *
 * @package App\Http\Controllers
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-23 16:16:56
 */
class ClothesController extends Controller
{

    public function createClothes(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required|string|max:20',
            'desc'   => 'nullable|string|max:20',
            'cat_id' => 'required|integer',
            // 'cat_id'   => 'required|integer|exists:category',
            'price'  => 'nullable|Numeric',
            'season' => 'required|integer|in:1,2,3,4',
            'photo'  => 'nullable|file',
        ]);

        $fileName = '';
        $photo = $request->file('photo');
        if (! empty($photo) && $photo->isValid()) {
            $fileName = $photo->getFilename() . '.' . $photo->extension();
            $request->file('photo')
                    ->move(CLOTHES_PATH, $fileName);
        }

        $clothes = new Clothes();
        $data = $request->all();
        $data['img_path'] = $fileName;
        if (! $clothes->create($data)) {
            throw new addException();
        }

        return responseJson(Code::SUCCESS);
    }

    public function getAllClothes(Request $request)
    {
        $startPage = $request->get('start_page', 1);
        $pageSize = $request->get('page_size', 10);
        $offset = ($startPage - 1) * $pageSize;

        $result = Clothes::getAllClothes($offset, $pageSize);
        if ($result['data']->isEmpty()) {
            throw new DataNotFoundException();
        }

        return responseJson(Code::SUCCESS, $result['data'], $result['total']);
    }

    public function getAllInSeason(Request $request)
    {
        $this->validate($request,
            ['id' => 'required|integer|in:1,2,3,4']
        );

        $result = Clothes::getAllInSeason($request->get('id'));
        if ($result['data']->isEmpty()) {
            throw new DataNotFoundException();
        }

        return responseJson(Code::SUCCESS, $result['data'], $result['total']);
    }

    public function getTrashClothes()
    {
        $clothes = Clothes::onlyTrashed()->get();
        if ($clothes->isEmpty()) {
            throw new DataNotFoundException();
        }

        return responseJson(Code::SUCCESS,$clothes);
    }

    public function restoreClothes(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string',
        ]);

        $clothesID = $request->get('id');

        if ($clothesID == 'all') {
            $clothes= Clothes::withTrashed();
        } elseif (strpos($clothesID,',')) {
            $clothesID = explode(',',$clothesID);
            // 恢复多件衣物
            $clothes= Clothes::withTrashed()->whereIn('id',$clothesID);
        } else {
            // 恢复单件衣物
            $clothes = Clothes::withTrashed()->where('id','=',$clothesID);
        }

        if (empty($clothes)) {
            throw new DataNotFoundException(['errorMsg' => '未找到需要还原的衣物.']);
        }

        if (! $clothes->restore()) {
            throw new UpdateException(['errorMsg' => '还原衣物失败']);
        }

        return responseJson(Code::SUCCESS);
    }

    public function deleteClothes(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $clothes = Clothes::find($request->get('id'));

        if (empty($clothes)) {
            throw new DataNotFoundException();
        }

        $clothes->delete();
        if (! $clothes->trashed()) {
            throw new UpdateException();
        }

        return responseJson(Code::SUCCESS);
    }

    public function getAllInCategory(Request $request)
    {
        $this->validate($request,
            ['id' => 'required|integer']
        );

        $result = Clothes::getAllInCategory($request->get('id'));
        if ($result['data']->isEmpty()) {
            throw new DataNotFoundException();
        }

        return responseJson(Code::SUCCESS, $result['data'], $result['total']);
    }

    public function updateClothes(Request $request)
    {
        $this->validate($request, [
            'id'       => 'required|integer',
            'name'     => 'required|string|max:20',
            'desc'     => 'nullable|string|max:20',
            'cat_id'   => 'required|integer',
            // 'cat_id'   => 'required|integer|exists:category',
            'price'    => 'nullable|Numeric',
            'season'   => 'required|integer|in:1,2,3,4',
            'img_path' => 'nullable|string',
        ]);

        $clothes = Clothes::find($request->get('id'));
        if (empty($clothes)) {
            throw new DataNotFoundException();
        }

        if (! $clothes->update($request->all())) {
            throw new UpdateException();
        }

        return responseJson(Code::SUCCESS);
    }

}