<?php

namespace Medlib\Http\Controllers\Messages;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Medlib\Services\CreateMessageService;
use Medlib\Repositories\User\UserRepository;
use Medlib\Http\Requests\CreateMessageRequest;
use Illuminate\Http\Response as IlluminateResponse;

/**
 * @Middleware("auth")
 */
class MessageController extends Controller
{
    public function __construct()
    {
        Carbon::setToStringFormat(DateTime::ISO8601);
    }

    /**
     * Display a listing of the message.
     * @Get("message", as="message.all")
     * @Middleware("auth")
     *
     * @param \Medlib\Repositories\User\UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserRepository $userRepository)
    {
        //$user = Auth::user();

        $messages = $userRepository->findByIdWithMessages(Auth::id());

        /**
         * return view('messages.index', compact('messages', 'user'));
         */
        return $this->response($messages);
    }

    /**
     * Show the form for creating a new message.
     * @Get("message", as="message.compose")
     * @Middleware("auth")
     *
     * @param  string  $username
     * @param \Medlib\Repositories\User\UserRepository $userRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($username, UserRepository $userRepository)
    {
        $currentUser = Auth::user();
        $user = $userRepository->findByUsername($username);

        if (!$user) {
            return redirect()->back();
        }
        return view('messages.create', compact('currentUser', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     * @Post("message", as="message.store")
     * @Middleware("auth")
     *
     * @param  \Medlib\Http\Requests\CreateMessageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateMessageRequest $request)
    {
        $massage = $this->dispatch(new CreateMessageService($request));

        return $this->responseWithSuccess($massage);
    }

    /**
     * Display the specified resource.
     * @Get("message/{username}", as="message.show")
     * @Middleware("auth")
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        if ($username == "compose") {
            dd("composition de message sans user");
        }

        dd("Show the message for :", $username);
    }

    /**
     * Remove the specified resource from storage.
     * @Delete("message/delete", as="message.delete")
     * @Middleware("auth")
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        dd($request);
    }
}
