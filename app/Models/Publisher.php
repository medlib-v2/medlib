<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'publishers';

    protected $guarded = ['publisher_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'place'];
}
