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
            'body' => 'required',
            'sender_id' => 'required|numeric',
            'receiver_id' => 'required|numeric',
            'conversation_id' => 'required|numeric'
        ];
    }
}
