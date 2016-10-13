<?php

namespace Medlib\Repositories\Message;

use Medlib\Models\Message;
use Medlib\Models\User;

interface MessageRepository
{
	public function findById($id);
	public function findByIdWithMessageResponses($id);
	
}