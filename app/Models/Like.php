<?php

namespace Medlib\Models;

use Medlib\Models\Feed;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{


    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','feed_id'];

    /**
     * @var array
     */
    public $with = ['user'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * @param $type
     * @return $this
     */
    public function withType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
}
