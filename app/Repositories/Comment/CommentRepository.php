<?php

namespace Medlib\Repositories\Comment;

use Medlib\Models\User;

interface CommentRepository
{
    public function getCommentByFeedAndUser(User $user);

    public function getCommentById($IdComment);
}
