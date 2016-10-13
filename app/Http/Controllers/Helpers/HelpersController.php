<?php

namespace Medlib\Http\Controllers\Helpers;


use Illuminate\Http\Request;
use Medlib\Http\Controllers\Controller;


class HelpersController extends Controller {


    public function index(){

        return "Home Helper";
    }

    public function deletingAccount(){

        return "Helper to deleting account";
    }


}