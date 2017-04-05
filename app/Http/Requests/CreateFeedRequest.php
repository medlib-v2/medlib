<?php

namespace Medlib\Http\Requests;

use Medlib\Http\Requests\Request;

class CreateFeedRequest extends Request
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
        /**
         * $imgfiles = ['image' => $this->images];
         * $rules = ['image.*' => 'required|mimes:jpeg,jpg,png,gif|image'];
         */
        return [
            'user_id' => 'required',
            'timeline_id' => 'required',
            'body'    => 'required',
            'type' => 'required'
        ];
    }
}