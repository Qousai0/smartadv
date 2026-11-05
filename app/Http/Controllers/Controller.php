<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function controllerfunc() {
        $name = 'qousai hassan  Doe';
        $students = ['sara', 'yara', 'noor',];
        return view('hello')->with('name', $name)->with('stud', $students);
    }
}
