<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->locale;
    }
}
