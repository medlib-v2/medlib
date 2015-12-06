<?php

namespace Medlib\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Str;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'profession',
        'location',
        'date_of_birth',
        'gender',
        'user_active',
        'account_type',
        'user_avatar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getName() {

        if($this->first_name && $this->last_name) {

            return Str::ucfirst($this->first_name)." ".Str::upper($this->last_name);
        }

        if($this->first_name) {
            return Str::ucfirst($this->first_name);
        }

        return null;
    }

    public function getUsername() {

        return $this->username;
    }

    public function getNameOrUsername() {

        return $this->getName() ?: $this->username;
    }

    public function getAvatar() {

            return $this->user_avatar ?: 'default.jpg';
    }

    public function getFirstNameOrUsername() {

        return $this->first_name ?: $this->username;
    }

    public function getProfession() {

        if($this->profession) return $this->profession;
    }

    public function getFirstName() {

        return Str::ucfirst($this->first_name);
    }

    public function getLastName() {

        return Str::upper($this->last_name);
    }

    public function getEmail() {

        return $this->email;
    }

    public function userAccountIsActive() {

        if(!$this->user_active == true) {

            return false;
        }

        return true;
    }

}
