<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function index(){
        $animals = ['dog','cat','tiger'];

        return view('tests.index',array(
            'title' => 'Animals',
            'animals' => $animals
        ));
    }
}
