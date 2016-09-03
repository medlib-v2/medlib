<?php

namespace Medlib\Http\Controllers\Lang;

use Medlib\Http\Requests;
use Illuminate\Support\Facades\Request;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class LangController extends Controller {

    /**
     * Change the default language
     * @Get("/lang/{lang}", as="lang", middleware="web")
     *
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLang($lang) {

        /**
         * Save in session to re use on middleware
         * Cookie::make('lang', $lang, 360);
         **/
        if(Session::has('lang') === false or Session::get('lang') != $lang) {
            Session::set('lang', $lang);
        }
        if(Request::ajax()) {
            return Response::json(['response' => 'success', 'message' => 'Change with success']);
        }
        return redirect()->back();
    }
}
