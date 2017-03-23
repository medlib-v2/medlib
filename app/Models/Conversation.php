<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
         */
    protected $table = 'conversations';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['sender_id', 'receiver_id'];

    /**
    * The attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'active' => 'boolean',
        'archived' => 'boolean',
        'blocked' => 'boolean',
        'favorite' => 'boolean'
    ];

    public $with = [
        'messages',
        'sender',
        'receiver'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id')->latest();
    }

    public function latest_message()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id')->orderBy('created_at', 'desc');
    }

    public function users()
    {
        return  $this->belongsToMany(User::class, 'conversation_id', 'user_id');
    }
}