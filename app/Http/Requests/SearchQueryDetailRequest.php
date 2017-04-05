<?php

namespace Medlib\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchQueryDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query'    => 'required|min:3',
            'qdb' => 'required|not_in: ',
            'type' => 'required'
        ];
    }
}
