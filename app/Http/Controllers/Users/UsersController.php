<?php

namespace Medlib\Http\Controllers\Users;


use Illuminate\Http\Request;
use Medlib\Http\Controllers\Controller;

class UsersController extends Controller {


    public function index() {

        return view('users.users.profile');
    }

}