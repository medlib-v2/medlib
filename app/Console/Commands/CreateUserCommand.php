<?php

namespace Medlib\Console\Commands;

use RuntimeException;
use Medlib\Models\User;
use Illuminate\Console\Command;
use Medlib\Events\UserWasRegistered;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:create-user
                            {name : The name for the user}
                            {username : The username for the user}
                            {email : The email address for the user}
                            {password? : The password for the user, one will be generated if not supplied}
                            {--no-email : Do not send a welcome email}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param \Medlib\Repositories\Activation\ConfirmationTokenRepository $token
     * @return mixed
     */
    public function handle(ConfirmationTokenRepository $token)
    {
        $arguments  = $this->argument();
        $send_email = (!$this->option('no-email'));

        $password_generated = false;
        if (!$arguments['password']) {
            $arguments['password'] = bcrypt(str_random(15));
            $password_generated    = true;
        }

        $validator = Validator::make($arguments, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if (!$validator->passes()) {
            throw new RuntimeException($validator->errors()->first());
        }
        list($first_name, $last_name) = explode(" ", $arguments['name']);

        $arguments['first_name'] = $first_name;
        $arguments['last_name'] = $last_name;

        $arguments['password'] = bcrypt($arguments['password']);

        $user = User::create($arguments);

        $message = 'The user has been created';

        if ($send_email) {
            $message = 'The user has been created and their account details have been emailed to ' . $user->email;
            $token->createConfirmationToken($user);
            event(new UserWasRegistered($user));
        } elseif ($password_generated) {
            $message .= ', however you elected to not email the account details to them. ';
            $message .= 'Their password is ' . $arguments['password'];
        }

        $this->info($message);
    }
}