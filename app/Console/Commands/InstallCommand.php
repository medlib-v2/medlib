<?php

namespace Medlib\Console\Commands;

use PDO;
use Exception;
use DateTimeZone;
use Medlib\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Validator;
use Medlib\Console\Commands\Traits\AskAndValidate;
use Symfony\Component\Console\Helper\FormatterHelper;

/**
 * Suppress all rules containing "unused" in this
 * class InstallCommand
 *
 * @SuppressWarnings("unused")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
 */
class InstallCommand extends Command
{
    use AskAndValidate;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Medlib application and configures the settings';

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
        if (!$this->verifyNotInstalled()) {
            return -1;
        }

        $this->clearCaches();

        $config = base_path('.env');

        if (!file_exists($config)) {
            copy(base_path('.env.example'), $config);
            config('app.key', 'SomeRandomString');
        }

        $this->line('');
        $this->info('**********************************');
        $this->info('  Welcome to Medlib Installation ');
        $this->info('**********************************');
        $this->line('');

        if (!$this->checkRequirements()) {
            return -1;
        }

        $this->line('Please answer the following questions:');
        $this->line('');

        $config = [
            'db' => $this->getDatabaseInformation(),
            'app'  => $this->getInstallInformation(),
            'mail' => $this->getEmailInformation(),
        ];

        if (config('jwt.secret') == false || config('jwt.secret') == 'changeme') {
            $this->info('Generating JWT secret');
            $this->line('');
            $config['jwt']['secret'] = $this->generateJWTKey();
        } else {
            $this->comment('JWT secret exists -- skipping');
        }

        $this->writeEnvFile($config);

        $this->generateKey();

        $this->migrate(($this->getLaravel()->environment() === 'local'));

        $this->optimize();

        $admin = $this->getAdminInformation();
        User::create($admin);

        $this->runNpmInstall();

        $this->line('');
        $this->info('🎆  Success! Medlib is now installed');
        $this->line('');
        $this->header('Next steps');
        $this->line('');
        $this->line('Example configuration files can be found in the "server" directory');
        $this->line('');
        $this->comment('1. Set up your web server, see either "nginx.conf" or "apache.conf"');
        $this->line('');
        $this->comment('2. Setup the cronjobs, see "crontab"');
        $this->line('');
        $this->comment('3. Setup the socket server & queue runner, see "supervisor.conf" for an example commands');
        $this->line('');
        $this->comment('4. Ensure that "storage" and "public/uploads" are writable by the webserver');
        $this->line('');
        $this->comment('5. Visit ' . $config['app']['url'] . ' and login with the details you provided to get started');
        $this->comment(PHP_EOL.'🎆  Remember, you can now run Medlib from localhost with `php artisan serve`.');
        $this->line('');

        $this->comment('Remember, you can always install/upgrade manually following the guide here:');
        $this->comment('or, for more configuration guidance, refer to');
        $this->info('📙  https://github.com/medlib-v2/medlib/wiki'.PHP_EOL);
        $this->comment('WIKI ROCKS WIKI RULES.');

        $this->comment('KTHXBYE.');
    }

    /**
     * Writes the configuration data to the config file.
     *
     * @param array $input The config data to write
     *
     * @return bool
     */
    protected function writeEnvFile(array $input)
    {
        $this->info('Writing configuration file');
        $this->line('');

        $path   = base_path('.env');
        $config = file_get_contents($path);

        /**
         * Move the socket value to the correct key
         */
        if (isset($input['app']['socket'])) {
            $input['socket']['url'] = $input['app']['socket'];
            unset($input['app']['socket']);
        }

        if (isset($input['app']['ssl'])) {
            foreach ($input['app']['ssl'] as $key => $value) {
                $input['socket']['ssl_' . $key] = $value;
            }

            unset($input['app']['ssl']);
        }

        foreach ($input as $section => $data) {
            foreach ($data as $key => $value) {
                $env = strtoupper($section . '_' . $key);

                $config = preg_replace('/' . $env . '=(.*)/', $env . '=' . $value, $config);
            }
        }

        /**
         * Remove SSL certificate keys if not using HTTPS
         */
        if (substr($input['socket']['url'], 0, 5) !== 'https') {
            foreach (['key', 'cert', 'ca'] as $key) {
                $key = strtoupper($key);

                $config = preg_replace('/SOCKET_SSL_' . $key . '_FILE=(.*)[\n]/', '', $config);
            }
        }

        /**
         * Remove keys not needed for sqlite
         */
        if (isset($input['db']['type']) && $input['db']['type'] === 'sqlite') {
            foreach (['host', 'database', 'username', 'password'] as $key) {
                $key = strtoupper($key);

                $config = preg_replace('/DB_' . $key . '=(.*)[\n]/', '', $config);
            }
        }

        /**
         * Remove keys not needed by SMTP
         */
        if ($input['mail']['driver'] !== 'smtp') {
            foreach (['host', 'port', 'username', 'password'] as $key) {
                $key = strtoupper($key);

                $config = preg_replace('/MAIL_' . $key . '=(.*)[\n]/', '', $config);
            }
        }

        /**
         * Remove github keys if not needed, only really exists on my dev copy
         */
        if (!isset($input['github']) || empty($input['github']['oauth_token'])) {
            $config = preg_replace('/GITHUB_OAUTH_TOKEN=(.*)[\n]/', '', $config);
        }

        /**
         * Remove trusted_proxies if not set
         */
        if (!isset($input['trusted']) || !isset($input['trusted']['proxied'])) {
            $config = preg_replace('/TRUSTED_PROXIES=(.*)[\n]/', '', $config);
        }

        return file_put_contents($path, trim($config) . PHP_EOL);
    }

    /**
     * Calls the artisan key:generate to set the APP_KEY.
     */
    private function generateKey()
    {
        if (config('app.key') !== false && config('app.key') !== 'SomeRandomString') {
            $this->info('Generating application key');
            $this->line('');
            $this->call('key:generate');
        } else {
            $this->comment('App key exists -- skipping');
        }
    }

    /**
     * Generates a key for JWT.
     *
     * @return string
     */
    protected function generateJWTKey()
    {
        return $this->call('medlib:generate-jwt-secret', [ '--return-key']);
    }

    /**
     * Calls the artisan migrate to set up the database
     * in development mode it also seeds the DB.
     *
     * @param bool $seed Whether or not to seed the database
     */
    protected function migrate($seed = false)
    {
        try {
            DB::connection();
        } catch (Exception $e) {
            $this->error('Unable to connect to database.');
            $this->error('Please fill valid database credentials into .env and rerun this command.');
            return;
        }
        $this->info('Running database migrations');
        $this->line('');
        $this->call('migrate', ['--force' => true]);
        $this->line('');

        if ($seed) {
            if (!User::count()) {
                $this->info('Seeding database');
                $this->line('');
                $this->call('db:seed', ['--force' => true]);
                $this->line('');
            } else {
                $this->comment('Data seeded -- skipping');
            }
        }
    }

    /**
     * Clears all Laravel caches.
     */
    protected function clearCaches()
    {
        $this->call('clear-compiled');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('view:clear');
    }

    /**
     * Runs the artisan optimize commands.
     */
    protected function optimize()
    {
        $this->clearCaches();

        if ($this->getLaravel()->environment() !== 'local') {
            $this->call('config:cache');
            $this->call('route:cache');
            $this->call('optimize', ['--force' => true]);
        }
    }

    /**
     * Prompts the user for the database connection details.
     *
     * @return array
     */
    private function getDatabaseInformation()
    {
        $this->header('Database details');

        $connectionVerified = false;

        while (!$connectionVerified) {

            $database = [];

            /**
             * Should we just skip this step if only one driver is available?
             */
            $type = $this->choice('Type', $this->getDatabaseDrivers(), 0);

            $database['type'] = $type;

            config('database.default', $type);

            if ($type !== 'sqlite') {
                $host = $this->ask('Host', '127.0.0.1');
                $name = $this->ask('Name', 'medlib');
                $user = $this->ask('Username', 'medlib');
                $pass = $this->secret('Password');

                $database['host']     = $host;
                $database['database'] = $name;
                $database['username'] = $user;
                $database['password'] = $pass;

                config('database.connections.' . $type . '.host', $host);
                config('database.connections.' . $type . '.database', $name);
                config('database.connections.' . $type . '.username', $user);
                config('database.connections.' . $type . '.password', $pass);
            }

            $connectionVerified = $this->verifyDatabaseDetails($database);
        }

        return $database;
    }

    /**
     * Prompts the user for the basic setup information.
     *
     * @return array
     */
    private function getInstallInformation()
    {
        $this->header('Installation details');

        $regions = $this->getTimezoneRegions();
        $locales = $this->getLocales();

        $urlCallback = function ($answer) {
            $validator = Validator::make(['url' => $answer], [
                'url' => 'url',
            ]);

            if (!$validator->passes()) {
                throw new \RuntimeException($validator->errors()->first('url'));
            }

            return preg_replace('#/$#', '', $answer);
        };

        $url    = $this->askAndValidate('Application URL ("http://medlib.app" for example)', [], $urlCallback);
        $region = $this->choice('Timezone region', array_keys($regions), 0);

        if ($region !== 'UTC') {
            $locations = $this->getTimezoneLocations($regions[$region]);

            $region .= '/' . $this->choice('Timezone location', $locations, 0);
        }

        $socket = $this->askAndValidate('Socket URL', [], $urlCallback, $url);

        /**
         * If the URL doesn't have : in twice (the first is in the protocol, the second for the port)
         */
        if (substr_count($socket, ':') === 1) {
            /**
             * Check if running on nginx, and if not then add it
             */
            $process = new Process('which nginx');
            $process->setTimeout(null);
            $process->run();

            if (!$process->isSuccessful()) {
                $socket .= ':6001';
            }
        }

        $pathCallback = function ($answer) {
            $validator = Validator::make(['path' => $answer], [
                'path' => 'required',
            ]);

            if (!$validator->passes()) {
                throw new \RuntimeException($validator->errors()->first('path'));
            }

            if (!file_exists($answer)) {
                throw new \RuntimeException('File does not exist');
            }

            return $answer;
        };

        $ssl = null;
        if (substr($socket, 0, 5) === 'https') {
            $ssl = [
                'key_file'  => $this->askAndValidate('SSL key File', [], $pathCallback),
                'cert_file' => $this->askAndValidate('SSL certificate File', [], $pathCallback),
                'ca_file'   => $this->askAndValidate('SSL certificate authority file', [], $pathCallback),
            ];
        };

        // If there is only 1 locale just use that
        if (count($locales) === 1) {
            $locale = $locales[0];
        } else {
            $default = array_search(config('app.fallback_locale'), $locales, true);
            $locale  = $this->choice('Language', $locales, $default);
        }

        return [
            'url'      => $url,
            'timezone' => $region,
            'socket'   => $socket,
            'ssl'      => $ssl,
            'locale'   => $locale,
        ];
    }

    /**
     * Prompts the user for the details for the email setup.
     *
     * @return array
     */
    private function getEmailInformation()
    {
        $this->header('Email details');

        $email = [];

        $driver = $this->choice('Type', ['smtp', 'sendmail', 'mail'], 0);

        if ($driver === 'smtp') {
            $host = $this->ask('Host', 'localhost');

            $port = $this->askAndValidate('Port', [], function ($answer) {
                $validator = Validator::make(['port' => $answer], [
                    'port' => 'integer',
                ]);

                if (!$validator->passes()) {
                    throw new \RuntimeException($validator->errors()->first('port'));
                };

                return $answer;
            }, 25);

            $user = $this->ask('Username');
            $pass = $this->secret('Password');

            $email['host']     = $host;
            $email['port']     = $port;
            $email['username'] = $user;
            $email['password'] = $pass;
        }

        $fromName = $this->ask('From name', 'Medlib');

        $fromAddress = $this->askAndValidate('From address', [], function ($answer) {
            $validator = Validator::make(['from_address' => $answer], [
                'from_address' => 'email',
            ]);

            if (!$validator->passes()) {
                throw new \RuntimeException($validator->errors()->first('from_address'));
            };

            return $answer;
        }, 'no-reply@medlib.app');

        $email['from_name']    = $fromName;
        $email['from_address'] = $fromAddress;
        $email['driver']       = $driver;

        return $email;
    }

    /**
     * Prompts for the admin user details.
     *
     * @return array
     */
    private function getAdminInformation()
    {
        $this->header('Admin details');

        $name = $this->ask('Name', 'Admin System');

        $username = $this->askAndValidate('Username', [], function ($answer) {
            $validator = Validator::make(['username' => $answer], [
                'username' => 'unique:users|alpha_dash|min:3|max:15',
            ]);

            if (!$validator->passes()) {
                throw new \RuntimeException($validator->errors()->first('username'));
            };

            return $answer;
        });

        $emailAddress = $this->askAndValidate('Email address', [], function ($answer) {
            $validator = Validator::make(['email_address' => $answer], [
                'email_address' => 'email',
            ]);

            if (!$validator->passes()) {
                throw new \RuntimeException($validator->errors()->first('email_address'));
            };

            return $answer;
        });

        $password = $this->askSecretAndValidate('Password', [], function ($answer) {
            $validator = Validator::make(['password' => $answer], [
                'password' => 'min:6',
            ]);

            if (!$validator->passes()) {
                throw new \RuntimeException($validator->errors()->first('password'));
            };

            return $answer;
        });

        return [
            'name'     => $name,
            'username'  => $username,
            'email'    => $emailAddress,
            'password' => bcrypt($password),
        ];
    }

    /**
     * Run the installation helper.
     */
    protected function runNpmInstall()
    {
        $this->info('Installing NPM Dependencies...');
        $path = getcwd();

        $process = (new Process('yarn install --no-progress', $path))->setTimeout(null);
        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            $process->setTty(true);
        }
        $process->run(function ($type, $line) {
            $this->info($line);
        });
    }

    /**
     * Verifies that the database connection details are correct.
     *
     * @param array $database The connection details
     *
     * @return bool
     */
    private function verifyDatabaseDetails(array $database)
    {
        if ($database['type'] === 'sqlite') {
            return touch(database_path('database.sqlite'));
        }

        try {
            $connection = new PDO(
                $database['type'] . ':host=' . $database['host'] . ';dbname=' . $database['database'],
                $database['username'],
                $database['password'],
                [
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT    => 2,
                ]
            );

            unset($connection);

            return true;
        } catch (\Exception $error) {
            $this->block([
                'Medlib could not connect to the database with the details provided. Please try again.',
                PHP_EOL,
                $error->getMessage(),
            ]);
        }

        return false;
    }

    /**
     * Ensures that Medlib has not been installed yet.
     *
     * @return bool
     */
    private function verifyNotInstalled()
    {
        if (config('app.key') !== false && config('app.key') !== 'SomeRandomString') {
            $this->block([
                'You have already installed Medlib!',
                PHP_EOL,
                'If you were trying to update Medlib, please use "php artisan medlib:update" instead.',
            ]);

            return false;
        }

        return true;
    }

    /**
     * Checks the system meets all the requirements needed to run Medlib.
     *
     * @return bool
     */
    protected function checkRequirements()
    {
        $errors = false;

        /**
         * Check PHP version:
         */
        if (!version_compare(PHP_VERSION, '5.6.4', '>=')) {
            $this->error('PHP 5.6.4 or higher is required');
            $errors = true;
        }

        /**
         * Check for required PHP extensions
         */
        $requiredExtensions = ['PDO', 'curl', 'gd', 'json',
            'tokenizer', 'openssl', 'mbstring',
        ];

        foreach ($requiredExtensions as $extension) {
            if (!extension_loaded($extension)) {
                $this->error('Extension required: ' . $extension);
                $errors = true;
            }
        }

        if (!count($this->getDatabaseDrivers())) {
            $this->error(
                'At least 1 PDO driver is required. Either sqlite, mysql, pgsql or sqlsrv, check your php.ini file'
            );
            $errors = true;
        }

        /**
         * Functions needed by symfony process
         */
        $requiredFunctions = ['proc_open'];

        foreach ($requiredFunctions as $function) {
            if (!function_exists($function)) {
                $this->error('Function required: ' . $function . '. Is it disabled in php.ini?');
                $errors = true;
            }
        }

        /**
         * Programs needed in $PATH
         */
        $requiredCommands = ['ssh', 'ssh-keygen', 'git', 'scp', 'tar', 'gzip', 'rsync', 'bash'];

        foreach ($requiredCommands as $command) {
            $process = new Process('which ' . $command);
            $process->setTimeout(null);
            $process->run();

            if (!$process->isSuccessful()) {
                $this->error('Program not found in path: ' . $command);
                $errors = true;
            }
        }

        $requiredOne = ['node', 'nodejs'];
        $found        = false;
        foreach ($requiredOne as $command) {
            $process = new Process('which ' . $command);
            $process->setTimeout(null);
            $process->run();
            if ($process->isSuccessful()) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->error('node.js was not found');
            $errors = true;
        }

        /**
         * Files and directories which need to be writable
         */
        $writable = ['.env', 'storage', 'storage/logs', 'storage/app', 'storage/app/mirrors',
            'storage/framework', 'storage/framework/cache', 'storage/framework/sessions',
            'storage/framework/views', 'bootstrap/cache', 'public/uploads', 'public/avatars',
        ];

        foreach ($writable as $path) {
            if (!is_writeable(base_path($path))) {
                $this->error($path . ' is not writeable');
                $errors = true;
            }
        }

        /**
         * Check that redis is running
         */
        try {
            Redis::connection()->ping();
        } catch (\Exception $e) {
            $this->error('Redis is not running');
            $errors = true;
        }

        $driver = env('QUEUE_DRIVER');

        if (isset($driver) && $driver === 'beanstalkd') {
            $connected = Queue::connection()->getPheanstalk()
                ->getConnection()
                ->isServiceListening();

            if (!$connected) {
                $this->error('Beanstalkd is not running');
                $errors = true;
            }
        }

        if ($errors) {
            $this->line('');
            $this->block('Medlib cannot be installed. Please review the errors above before continuing.');
            $this->line('');

            return false;
        }

        return true;
    }

    /**
     * Gets an array of available PDO drivers which are supported by Laravel.
     *
     * @return array
     */
    private function getDatabaseDrivers()
    {
        $available = collect(PDO::getAvailableDrivers());

        return $available->intersect(['mysql', 'sqlite', 'pgsql', 'sqlsrv'])
            ->all();
    }

    /**
     * Gets a list of timezone regions.
     *
     * @return array
     */
    private function getTimezoneRegions()
    {
        return [
            'UTC'        => DateTimeZone::UTC,
            'Africa'     => DateTimeZone::AFRICA,
            'America'    => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Asia'       => DateTimeZone::ASIA,
            'Atlantic'   => DateTimeZone::ATLANTIC,
            'Australia'  => DateTimeZone::AUSTRALIA,
            'Europe'     => DateTimeZone::EUROPE,
            'Indian'     => DateTimeZone::INDIAN,
            'Pacific'    => DateTimeZone::PACIFIC,
        ];
    }

    /**
     * Gets a list of available locations in the supplied region.
     *
     * @param int $region The region constant
     *
     * @return array
     *
     * @see DateTimeZone
     */
    private function getTimezoneLocations($region)
    {
        $locations = [];

        foreach (DateTimeZone::listIdentifiers($region) as $timezone) {
            $locations[] = substr($timezone, strpos($timezone, '/') + 1);
        }

        return $locations;
    }

    /**
     * Gets a list of the available locales.
     *
     * @return array
     */
    private function getLocales()
    {
        /**
         * Get the locales from the files on disk
         */
        $locales = File::directories(base_path('resources/lang/'));

        array_walk($locales, function (&$locale) {
            $locale = basename($locale);
        });

        return $locales;
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

    /**
     * Outputs a header block.
     *
     * @param string $header The text to output
     */
    protected function header($header)
    {
        $this->block($header, 'question');
    }
}
