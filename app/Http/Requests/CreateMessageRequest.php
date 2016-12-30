<?php

namespace Medlib\Http\Requests;

use Medlib\Http\Requests\Request;

class CreateMessageRequest extends Request
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
            'receiver_id'           => 'required',
            'body'                  => 'required',
            'sender_id'             => 'required',
            'sender_profile_image'  => 'required',
            'sender_name'           => 'required'
        ];
    }
}
