<?php

namespace Medlib\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        Commands\MakeModelCommand::class,
        Commands\MakeModelCommand::class,
        Commands\CreateUserCommand::class,
        Commands\MigrationsCommand::class,
        Commands\DatabaseSeederCommand::class,
        Commands\MigrateSchemaCommand::class,
        Commands\RegisterCommandsCommand::class,
        Commands\GenerateJWTSecretCommand::class,
        Commands\ClearOrphanAvatarsCommand::class,
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

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
