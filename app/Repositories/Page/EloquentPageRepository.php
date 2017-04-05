<?php

namespace Medlib\Repositories\Page;

use Medlib\Models\Page;

class EloquentPageRepository implements PageRepository
{

    /**
     * @param Page $page
     * @return mixed
     */
    public function findByPage(Page $page)
    {
        // TODO: Implement findByPage() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByIdWithTimeline($id)
    {
        return Page::where('timeline_id', '=', $id)->first();
    }
}