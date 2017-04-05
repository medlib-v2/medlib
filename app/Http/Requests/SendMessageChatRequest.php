<?php

namespace Medlib\Http\Requests;

use Medlib\Http\Requests\Request;

class SendMessageChatRequest extends Request
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
            'receiver_id' => 'required',
            'message' => 'required'
        ];
    }
}
