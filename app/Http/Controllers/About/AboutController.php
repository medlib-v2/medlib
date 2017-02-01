<?php

namespace Medlib\Http\Controllers\About;

use Illuminate\Support\Facades\Mail;
use Medlib\Http\Controllers\Controller;
use Medlib\Http\Requests\ContactFormRequest;

/**
 * @Middleware("guest")
 */
class AboutController extends Controller
{
    /**
     * Show the About Page
     *
     * @Get("/site/about", as="contact.index")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    }

    /**
     * Show the Contact Page
     *
     * @Get("/site/contact", as="contact.show")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('about.contact');
    }

    /**
     * Send an email to Medlib Team
     *
     * @Post("/site/contact", as="contact.store")
     * @Middleware("guest")
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(ContactFormRequest $request)
    {
        Mail::send('emails.contact', [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_message' => $request->get('message')
        ], function ($message) {
            $message->from(config('mail.from'));
            $message->to(config('mail.from'), 'Admin')->subject('Medlib Feedback');
        });
        return redirect()->route('contact.show')->with('message', 'Thanks for contacting us!');
    }
}
