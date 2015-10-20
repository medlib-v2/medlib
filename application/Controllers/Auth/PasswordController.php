<?php
namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Medlib\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    * Password Reset Controller
    */
    use ResetsPasswords;
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
