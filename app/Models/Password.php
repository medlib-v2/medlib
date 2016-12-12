<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'password_resets';

    public $timestamps = false;
}
