<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
         */
    protected $table = 'followers';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['user_id', 'follower_id'];

    /**
    * The attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = ['created_at', 'updated_at'];
}