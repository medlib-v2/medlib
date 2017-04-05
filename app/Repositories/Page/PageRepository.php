<?php

namespace Medlib\Repositories\Page;

use Medlib\Models\Page;

interface PageRepository
{
    /**
     * @param Page $page
     * @return mixed
     */
    public function findByPage(Page $page);

    /**
     * @param $id
     * @return mixed
     */
    public function findByIdWithTimeline($id);
}
