<?php

namespace Medlib\Http\Controllers\About;

use Medlib\Http\Requests;
use Illuminate\Http\Request;
use Medlib\Http\Controllers\Controller;
use Medlib\Http\Requests\ContactFormRequest;

class AboutController extends Controller
{
    public function create()
    {
        return view('about.contact');
    }

    public function store(ContactFormRequest $request)
    {
        \Mail::send('emails.contact', [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_message' => $request->get('message')
        ], function($message) { 
            $message->from('noreply.medlib@gmail.com');
            $message->to('noreply.medlib@gmail.com', 'Admin')->subject('Medlib Feedback');
        });
        return \Redirect::route('contact.show')->with('message', 'Thanks for contacting us!');
    }
}
