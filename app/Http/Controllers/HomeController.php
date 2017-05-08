<?php

namespace Medlib\Http\Controllers;

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
        $config = config('yaz.zebra');

        $datasource = [];

        foreach ($config as $name) {
            $datasource +=  [
                $name['instance'] => [
                    'fullname' => $name['fullname'],
                    'syntax' => $name['format']
                ]
            ];
        }
        /**
        $manifest = file_get_contents(base_path('public/mix-manifest.json'));

        $view = view('app', compact('datasource'));

        return response($view)->withCookie(cookie('manifest', $manifest));
        **/
        return view('app', compact('datasource'));
    }
}
