<?php

namespace Medlib\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
         */
    protected $table = 'notifications';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['read_at'];

    /**
     *
     */
    public function readAt()
    {
        $this->update(['read_at' => Carbon::now()]);
    }
}
