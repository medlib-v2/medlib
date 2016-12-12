<?php

namespace Medlib\Models;

use Medlib\Models\User;
use Illuminate\Database\Eloquent\Model;

class ConfirmationToken extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = ['user_id', 'token'];

    /**
     * The attributes excluded from the model's JSON form.
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'confirmation_tokens';

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getToken()
    {
        return $this->token;
    }

    /**
     * Boot the model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = self::generateToken();
        });
    }
    /**
     * Generate the verification token.
     *
     * @return string
     */
    public static function generateToken()
    {
        return str_random(64).config('app.key');
    }
}
