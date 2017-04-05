<?php

namespace Medlib\Http\Controllers\Errors;

use Illuminate\Http\Request;
use Medlib\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function notFoundHttp()
    {
        return view('errors.404');
    }
}