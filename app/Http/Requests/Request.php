<?php

namespace Medlib\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * @return bool
     */
    public function wantsJson()
    {
        return parent::wantsJson();
    }
}
