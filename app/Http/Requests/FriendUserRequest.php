<?php

namespace Medlib\Http\Requests;

use Medlib\Http\Requests\Request;

class FriendUserRequest extends Request
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
            'username' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'response' => 'failed',
            'message' => 'Something went wrong please try again.'
        ];
    }
}
