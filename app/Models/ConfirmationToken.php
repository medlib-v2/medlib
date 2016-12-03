<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class ConfirmationToken extends Model
{
    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'confirmation_tokens';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}