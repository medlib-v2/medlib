<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class Social extends Model {

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'social_logins';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}