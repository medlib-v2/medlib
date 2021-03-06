<?php

namespace Medlib\Http\Controllers;

use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    /**
     * Show the Index Page
     * @Get("/", as="index", middleware="guest")
     *
     * @return mixed
     */
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