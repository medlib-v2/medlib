<?php

namespace Medlib\Repositories\Message;

use Medlib\Models\Message;

class EloquentMessageRepository implements MessageRepository
{
    /**
     * Fetch a message by id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        return Message::find($id);
    }

    /**
     * Fetch a message with all responses attached.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findByIdWithMessageResponses($id)
    {
        return Message::with(['user', 'conversation'])
            ->where([
                ['user_id', '=', $id]
            ])->orderBy('created_at', 'desc')->get();

        //return Message::with(['MessageResponses'])->find($id);
    }
}
