<?php

namespace Medlib\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Medlib\Commands\Command;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        Commands\TestCommand::class,
        Commands\ResetCommand::class,
        Commands\UpdateCommand::class,
        Commands\InstallCommand::class,
        Commands\CreateUserCommand::class,
        Commands\GenerateJWTSecretCommand::class,
        Commands\DeleteExpiredConfirmationTokensCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
