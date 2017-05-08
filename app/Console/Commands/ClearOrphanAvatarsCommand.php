<?php

namespace Medlib\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Suppress all rules containing "unused" in this
 * class ClearOrphanAvatarsCommand
 *
 * @SuppressWarnings("unused")
 */
class ClearOrphanAvatarsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medlib:purge-avatars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purges out avatar images which are no longer in use by an account';

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
        $this->purgeOldAvatars();
    }

    /**
     * Remove unused avatar files from disk.
     *
     * @return void
     */
    private function purgeOldAvatars()
    {
        /**
         * Build up a list of all avatar images
         */
        $avatars = glob(public_path() . '/avatars/*.*');

        /**
         * Remove the public_path() from the path so that they match values in the DB
         */
        array_walk($avatars, function (&$avatar) {
            $avatar = str_replace(public_path(), '', $avatar);
        });

        $allAvatars = collect($avatars);

        /**
         * Get all avatars currently assigned
         */
        $currentAvatars = DB::table('users')
            ->whereNotNull('user_avatar')
            ->pluck('user_avatar');

        /**
         * Compare the 2 collections get a list of avatars which are no longer assigned
         */
        $orphanAvatars = $allAvatars->diff($currentAvatars);

        $this->info('Found ' . $orphanAvatars->count() . ' orphaned avatars');

        /**
         * Now loop through the avatars and delete them from storage
         */
        foreach ($orphanAvatars as $avatar) {
            $avatarPath = public_path() . $avatar;

            /**
             * Don't delete recently created files as they could be temp files from the uploader
             */
            if (filemtime($avatarPath) > strtotime('-15 minutes')) {
                $this->info('Skipping ' . $avatar);
                continue;
            }

            if (!unlink($avatarPath)) {
                $this->error('Failed to delete ' . $avatar);
            } else {
                $this->info('Deleted ' . $avatar);
            }
        }
    }
}
