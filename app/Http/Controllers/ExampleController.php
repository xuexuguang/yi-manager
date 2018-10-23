<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function test()
    {
        print_r($_ENV);die;
        return 1/0;
    }

    //
}
