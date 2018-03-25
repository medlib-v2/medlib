<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Suppress all rules containing "unused" in this
 * class GenerateJWTSecretCommand
 *
 * @SuppressWarnings("unused")
 */
class GenerateJWTSecretCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'medlib:generate-jwt-secret {--return-key : Return the generated key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the JWTAuth secret key used to sign the tokens';

    /**
     * Execute the console command.
     *
     * @throws \RuntimeException
     * @return string
     */
    public function fire()
    {
        $returnKey = $this->option('return-key');

        $key = Str::random(32);

        if ($returnKey) {
            return $key;
        }

        $path = base_path('.env');
        $content = file_get_contents($path);
        if (strpos($content, 'JWT_SECRET=') !== false) {
            file_put_contents($path, str_replace('JWT_SECRET=', "JWT_SECRET=$key", $content));
        } else {
            file_put_contents($path, $content.PHP_EOL."JWT_SECRET=$key");
        }
        $this->info('JWT secret key generated. Look for `JWT_SECRET` in .env.');
    }
}
