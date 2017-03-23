<?php

namespace Medlib\Repositories\Group;

use Medlib\Models\Group;

interface GroupRepository
{
    /**
     * @param Group $user
     * @return mixed
     */
    public function findByPage(Group $user);

    /**
     * @param $id
     * @return mixed
     */
    public function findByIdWithTimeline($id);
}
