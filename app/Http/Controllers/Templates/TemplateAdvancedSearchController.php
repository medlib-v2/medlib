<?php

namespace Medlib\Http\Controllers\Templates;

use Illuminate\Http\Request;

use Medlib\Http\Requests;
use Medlib\Http\Controllers\Controller;

/**
 * @Middleware("guest")
 */
class TemplateAdvancedSearchController extends Controller
{

    /**
     * Return the Template html
     *
     * @Get("templates-input-advanced", as="search.advanced.templates-input")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getQueryForm(){

        if(request()->ajax()){
            return view('templates.templates-input-advanced');
        }
    }
}
