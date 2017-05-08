<?php

namespace Medlib\Repositories\Comment;

use Medlib\Models\User;
use Medlib\Models\Comment;

class EloquentCommentRepository implements CommentRepository
{
    /**
     * Get Comments posted by current user.
     *
     * @param \Medlib\Models\User $user
     * @return mixed
     */
    public function getCommentByFeedAndUser(User $user)
    {
        return Comment::whereIn('user_id', $user->id)->get();
    }

    /**
     * Get Comments posted by id comment.
     *
     * @param $idComment
     * @return mixed
     */
    public function getCommentById($idComment)
    {
        return Comment::where('id', $idComment)->get();
    }
}
