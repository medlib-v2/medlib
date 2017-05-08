<?php

namespace Medlib\Console\Commands;

use Carbon\Carbon;
use RuntimeException;
use Medlib\Models\User;
use Medlib\Models\Timeline;
use Illuminate\Console\Command;
use Medlib\Events\UserWasRegistered;
use Illuminate\Support\Facades\Validator;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

/**
 * Suppress all rules containing "unused" in this
 * class CreateUserCommand
 *
 * @SuppressWarnings("unused")
 */
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
     * @return void
     */
    public function handle(ConfirmationTokenRepository $token)
    {
        $arguments  = $this->argument();
        $sendEmail = (!$this->option('no-email'));

        $passwordGenerated = false;
        if (!$arguments['password']) {
            $arguments['password'] = bcrypt(str_random(15));
            $passwordGenerated    = true;
        }

        $validator = Validator::make($arguments, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if (!$validator->passes()) {
            throw new RuntimeException($validator->errors()->first());
        }

        $timeline = Timeline::create([
            'username' => $arguments['username'],
            'name'     => $arguments['name'],
            'type'     => 'user'
        ]);
        $arguments['timeline_id'] = $timeline->id;

        list($firstName, $lastName) = explode(" ", $arguments['name']);

        $arguments['first_name'] = $firstName;
        $arguments['last_name'] = $lastName;
        $arguments['password'] = bcrypt($arguments['password']);
        $arguments['profession'] = 'teacher';
        $arguments['date_of_birth'] = Carbon::create();
        $arguments['gender'] = 'male';
        $arguments['account_type'] = false;

        /**
         * Unset arguments no used
         */
        unset($arguments['name']);
        unset($arguments['command']);
        unset($arguments['0']);

        $user = User::create($arguments);

        $message = 'The user has been created';

        if ($sendEmail) {
            $message = 'The user has been created and their account details have been emailed to ' . $user->email;
            $token->createConfirmationToken($user);
            event(new UserWasRegistered($user));
        } elseif ($passwordGenerated) {
            $message .= ', however you elected to not email the account details to them. ';
            $message .= 'Their password is ' . $arguments['password'];
        }

        $this->info($message);
    }
}
