<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
         */
    protected $table = 'profiles';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['location', 'about','user_id'];

    /**
    * The attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}