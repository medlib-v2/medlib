<?php

namespace Medlib\Http\Controllers\Messages;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Medlib\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Medlib\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;

/**
 * Suppress all rules containing "unused" in this
 * class ConversationsController
 *
 * @SuppressWarnings("unused")
 * @Middleware("auth")
 */
class ConversationsController extends Controller
{
    public function __construct()
    {
        Carbon::setToStringFormat(DateTime::ISO8601);
    }

    public function index()
    {
        /**
         * return all conversations for the given user
         */
        return response()->json(
            Conversation::with(['messages.user', 'sender', 'receiver'])->where([
                ['sender_id', '=', Auth::user()->id]
            ])->orWhere([
                ['receiver_id', '=', Auth::user()->id]
            ])->orderBy('created_at', 'asc')->get()
        );
    }

    public function show(Request $request, $id)
    {
        return response()->json(
            Conversation::with(['messages.user', 'sender', 'receiver'])->where([
                ['id', '=', $id]
            ])->first()
        );
    }

    public function store(Request $request)
    {
        $data = $request->input();

        /**
         * check if an existing conversation exists
         */
        $conversation = Conversation::where([
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id']
        ])->orWhere([
            'receiver_id' => $data['sender_id'],
            'sender_id' => $data['receiver_id']
        ])->first();

        /**
         * if so return the conversation_id
         */
        if (!$conversation) {
            /**
             * if not create a new conversation and return it's id
             */
            $conversation = Conversation::create([
                'sender_id' => $data['sender_id'],
                'receiver_id' => $data['receiver_id'],
            ]);
        }
        return response()->json([
            'conversation' =>  Conversation::find($conversation->id)->first()
        ]);
    }
}
