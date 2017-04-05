<?php

namespace Medlib\Repositories\Group;

use Medlib\Models\Group;

class EloquentGroupRepository implements GroupRepository
{
    /**
     * @param Group $group
     * @return mixed
     */
    public function findByPage(Group $group)
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
