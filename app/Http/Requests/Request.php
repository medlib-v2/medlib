<?php

namespace Medlib\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{
    /**
     * @return bool
     */
    public function wantsJson()
    {
        //return parent::wantsJson();
        return true;
    }
}
