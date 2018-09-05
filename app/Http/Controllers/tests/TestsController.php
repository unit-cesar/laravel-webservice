<?php

namespace App\Http\Controllers\tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestsController extends Controller
{
    //
    public function foo(Request $req)
    {
//        dd($req);
//        dd($req->all()); //Não funfa pra GET da rota, apenas se explicito na URL - ?id=234
        return isset($req['id']) ? "Controller ok! - id: " . $req['id'] : "Controller ok! - Sem ID";
    }

    public function fooPost(Request $req)
    {
//        dd($req);
//        dd($req->all());
        return (isset($req['id']) && $req['id']!='') ? "Controller ok! - id: " . $req['id'] : "Controller ok! - Sem ID";
    }
}
