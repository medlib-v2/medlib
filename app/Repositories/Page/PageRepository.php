<?php

namespace Medlib\Repositories\Page;

use Medlib\Models\Page;

interface PageRepository
{
    /**
     * @param Page $user
     * @return mixed
     */
    public function findByPage(Page $user);

    /**
     * @param $id
     * @return mixed
     */
    public function findByIdWithTimeline($id);
}
