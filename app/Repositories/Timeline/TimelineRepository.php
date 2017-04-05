<?php

namespace Medlib\Repositories;

use Medlib\Models\Timeline;
use InfyOm\Generator\Common\BaseRepository;

class TimelineRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'type',
    ];

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return Timeline::class;
    }
}
