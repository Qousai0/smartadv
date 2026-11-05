<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Firstcontroller extends Controller
{
    //
    function firstfunc() {
        $name = 'qousai first conttroleer';
        return  $name;
    }

    function requestfunction(Request $request, $id) {
        return $id;
    }
}
