<?php

namespace App\Validation;


use App\Exceptions\ParamsException;


class BaseValidate
{
    protected $rule = [];

    public function goCheck($data = [])
    {
        $validator = \Illuminate\Support\Facades\Validator::make(
            $data,
            $this->rule
        );

        if ($validator->fails()) {
            throw new ParamsException([
                'errorMsg' => $validator->messages()->first(),
            ]);
        }

        return true;
    }

}