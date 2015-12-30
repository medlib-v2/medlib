<?php

namespace Medlib\Repositories\User;

use Medlib\Models\User;

interface UserRepository
{	
	public function getPaginated($howMany, $byKeyword);
	public function findByUsername($username);
	public function findById($id);
	public function findManyById(array $ids);
	public function findByIdWithFeeds($id);
	public function findByIdWithMessages($id);
	public function findByIdWithFriends($userId);
}