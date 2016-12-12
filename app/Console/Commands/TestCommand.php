<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\FormatterHelper;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the phpunit command';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Running the phpunit');
        $result = system('./vendor/bin/phpunit --configuration phpunit.xml');
        list($tests, $assertions, $status) = explode(",", $result);

        if ($status) {
            $this->block($status);
        } else {
            $this->comment('KTHXBYE.');
        }
    }

    /**
     * A wrapper around symfony's formatter helper to output a block.
     *
     * @param string|array $messages Messages to output
     * @param string       $type     The type of message to output
     */
    protected function block($messages, $type = 'error')
    {
        $output = [];

        if (!is_array($messages)) {
            $messages = (array) $messages;
        }

        $output[] = '';

        foreach ($messages as $message) {
            $output[] = trim($message);
        }

        $output[] = '';

        $formatter = new FormatterHelper();
        $this->line($formatter->formatBlock($output, $type));
    }
}
