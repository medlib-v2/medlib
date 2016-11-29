<?php

namespace Medlib\Http\Controllers\Messages;

use Medlib\Http\Requests;
use Medlib\Models\Message;
use Illuminate\Http\Request;
use Medlib\Models\MessageResponse;
use Illuminate\Support\Facades\Auth;
use Medlib\Commands\CreateMessageCommand;
use Medlib\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\User\UserRepository;
use Medlib\Repositories\Message\MessageRepository;

/**
 * @Middleware("auth")
 */
class MessageController extends Controller {

    private $currentUser;

    public function __construct() {

    }
    /**
     * Display a listing of the message.
     * @Get("message", as="message.all")
     * @Middleware("auth")
     *
     * @param \Medlib\Repositories\User\UserRepository $userRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(UserRepository $userRepository) {

        $user = Auth::user();

        $messages = $userRepository->findByIdWithMessages($user->id);

        return view('messages.index', compact('messages', 'user'));
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
    public function create($username, UserRepository $userRepository) {

        $currentUser = Auth::user();
        $user = $userRepository->findByUsername($username);

        return view('messages.create', compact('currentUser', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     * @Post("message", as="message.store")
     * @Middleware("auth")
     *
     * @param UserRepository $userRepository
     * @param MessageRepository $messageRepository
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserRepository $userRepository, MessageRepository $messageRepository) {

        $validator = Validator::make($request->all(), ['body' => 'required']);

        if($validator->fails())  {
            return response()->json(['response' => 'failed', 'message' => $validator->messages()->first('body')]);
        }
        else  {

            /**
             * $this->dispatchFrom(CreateMessageCommand::class, $request);
             */
            $message = Message::createMessage($request->get('body'), $request->get('senderId'), $request->get('senderProfileImage'), $request->get('senderName'));

            $response = MessageResponse::createMessageResponse($request->get('body'), $request->get('senderId'), $request->get('receiverId'), $request->get('senderProfileImage'), $request->get('senderName'));

            $userRepository->findById($request->get('receiverId'))->messages()->save($message);

            $messageRepository->findById($message->id)->messageResponses()->save($response);

            $userRepository->findById($request->get('receiverId'))->messageResponses()->save($response);

            return response()->json(['response' => 'success', 'message' => 'Your message was sent.']);
        }
    }

    /**
     * Display the specified resource.
     * @Get("message/{username}", as="message.show")
     * @Middleware("auth")
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username) {
        if($username == "compose") {
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
    public function destroy(Request $request) {
        dd($request);
    }
}
