<?php

namespace Medlib\Repositories\Group;

use Medlib\Models\Group;

class EloquentGroupRepository implements GroupRepository
{

    /**
     * @param Group $user
     * @return mixed
     */
    public function findByPage(Group $user)
    {
        // TODO: Implement findByPage() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByIdWithTimeline($id)
    {
        return Group::where('timeline_id', '=', $id)->first();
    }
}
