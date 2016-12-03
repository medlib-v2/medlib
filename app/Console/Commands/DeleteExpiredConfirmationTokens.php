<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Medlib\Repositories\Activation\ConfirmationTokenRepository;

class DeleteExpiredConfirmationTokens extends Command
{
    /**
     * @var \Medlib\Repositories\Activation\ConfirmationTokenRepository
     */
    protected $confirmationTokenRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:delete-expired-activations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete activation records older than 72 hours.';

    /**
     * Create a new command instance.
     *
     * DeleteExpiredConfirmationTokens constructor.
     * @param \Medlib\Repositories\Activation\ConfirmationTokenRepository $confirmationTokenRepository
     */
    public function __construct(ConfirmationTokenRepository $confirmationTokenRepository)
    {
        parent::__construct();
        $this->confirmationTokenRepository = $confirmationTokenRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->confirmationTokenRepository->deleteExpiredConfirmationTokens();
    }
}
