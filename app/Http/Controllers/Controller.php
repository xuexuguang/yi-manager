<?php

namespace App\Http\Controllers;

use App\Exceptions\ParamsException;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function throwValidationException(Request $request, $validator)
    {
        $msg = $validator->errors()->first();
        throw new ParamsException(['errorMsg' => $msg]);
    }
}
