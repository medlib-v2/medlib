<?php

namespace Medlib\Http\Controllers;

use Illuminate\Support\Facades\Config;



class HomeController extends Controller
{
    public function index()
    {
        $config = Config::get('yaz.zebra');

        $datasource = [];

        foreach($config as $name) {
            $datasource +=  [
                $name['instance'] => [
                    'fullname' => $name['fullname'],
                    'syntax' => $name['database']['format']
                ]
            ];
        }

        return view("home", compact('datasource'));
    }
}