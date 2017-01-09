<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'editions';

    protected $guarded = ['edition_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
