<?php

namespace Medlib\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use Medlib\Http\Controllers\Controller;

class DashboardController extends Controller {


    public function index() {

        return view('dashboard.home');
    }

    public function books(){

        return view('dashboard.books');
    }

    public function history() {

        return "History";
    }

    public function viewed() {

        return "Viewed";
    }


}