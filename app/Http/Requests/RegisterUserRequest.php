<?php

namespace Medlib\Http\Requests;

use Medlib\Http\Requests\Request;

class RegisterUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		$timestamp = strtotime('-15 years');

		return [
			'first_name' => 'required|regex:/^[a-zA-Z\s]{3,64}$/i|min:3|max:20',
			'last_name' => 'required|regex:/^[a-zA-Z\s]{3,64}$/i|min:3|max:20',
			'username' => 'required|unique:users|alpha_dash|min:3|max:20',
			'email' => 'required|unique:users|email|max:255',
			'email_confirm' => 'required|max:255|same:email',
			'profession' => 'not_in: ',
			'password' => 'required|min:6',
			'password_confirm' => 'required|min:6|same:password',
			'day'	=>	'required|numeric|between:01,31',
			'month'	=>	'required|numeric|between:01,12',
			'year'	=>	'required|numeric|before:'.date('Y', $timestamp),
			'gender' =>	'required',
			'profileimage' =>	'required|image|mimes:jpeg,jpg,bmp,png,gif',
			'g-recaptcha-response' => 'required|recaptcha',
		];
	}

}
