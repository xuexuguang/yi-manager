<?php

namespace App\Http\Requests;


/**
 * Class ClothesRequest
 *
 * @package App\Http\Requests
 * @author  xiaoyi <769076918@qq.com>
 * @date    2018-10-24 11:34:56
 */
class ClothesRequest extends Request
{
    // TODO(xiaoyi):解决验证请求无法注入的问题
    public function rules()
    {
        dd(111);
        return [
            'name'   => 'required|string|max:20',
            'desc'   => 'nullable|string|max:20',
            'cat_id' => 'required|integer',
            // 'cat_id'   => 'required|integer|exists:category',
            'price'  => 'nullable|Numeric',
            'season' => 'required|integer|in:1,2,3,4',
            'photo'  => 'nullable|file',
        ];
    }

    public function messages()
    {
        return 111;
        // TODO: Implement messages() method.
    }
}