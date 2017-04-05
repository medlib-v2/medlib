<?php

namespace Medlib\Services;

use Medlib\Models\User;
use Medlib\Models\Feed;
use Medlib\Models\Media;
use Medlib\Models\Hashtag;
use Medlib\Models\Timeline;
use Medlib\Services\Service;
use Medlib\Services\ProcessImage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Medlib\Http\Requests\CreateFeedRequest;

class CreateFeedService extends Service
{

    /**
     * @var array
     */
    protected $input;

    /**
     * @var array
     */
    protected $images;

    /**
     * Create a new command instance.
     *
     * @param CreateFeedRequest $request
     */
    public function __construct(CreateFeedRequest $request)
    {
        parent::__construct();
        $this->input = $request->except(['post_images_upload']);
        $this->images = $request->file('post_images_upload');
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $timeline = [];
        $post = Feed::create($this->input);
        $post->follows()->sync([Auth::id()], true);

        /**
         * Upload images
         */
        if (isset($this->images) && !empty($this->images)) {
            foreach ($this->images as $postImage) {
                $strippedName = str_replace(' ', '', $postImage->getClientOriginalName());
                $photoName = date('Y-m-d-H-i-s').$strippedName;

                $destinationPath = config('image.upload_path').'feeds/'.$photoName;

                App::make(ProcessImage::class)->upload($postImage, $destinationPath, 60);

                $media = Media::create([
                    'title'  => $photoName,
                    'type'   => 'image',
                    'source' => $photoName,
                ]);

                $post->images()->attach($media);
            }
        }

        if ($post) {
            /**
             * Check for any mentions and notify them
             */
            preg_match_all('/(^|\s)(@\w+)/', $this->input['body'], $usernames);
            foreach ($usernames[2] as $username) {
                $timeline = User::where('username', str_replace('@', '', $username))->first();
                /**
                 * Notify the user
                 */
                //$notification = Notification::create(['user_id' => $timeline->user->id, 'post_id' => $post->id, 'notified_by' => Auth::id(), 'description' => Auth::user()->getName().' mentioned you in his post', 'type' => 'mention', 'link' => 'post/'.$post->id]);
            }
            $timeline = Timeline::where('id', $this->input['timeline_id'])->first();

            /**
             * Notify the user when someone posts on his timeline/page/group
             *÷/
            if ($timeline->type == 'page') {
            $notify_users = $timeline->page->users()->whereNotIn('user_id', [Auth::id()])->get();
            $notify_message = 'posted on this page';
            } elseif ($timeline->type == 'group') {
            $notify_users = $timeline->groups->users()->whereNotIn('user_id', [Auth::id()])->get();
            $notify_message = 'posted on this group';
            } else {
            $notify_users = $timeline->user()->whereNotIn('id', [Auth::id()])->get();
            $notify_message = 'posted on your timeline';
            }

            foreach ($notify_users as $notify_user) {
            //Notification::create(['user_id' => $notify_user->id, 'timeline_id' => $request->timeline_id, 'post_id' => $post->id, 'notified_by' => Auth::id(), 'description' => Auth::user()->getName().' '.$notify_message, 'type' => $timeline->type, 'link' => $timeline->username]);
            }
             **/


            /**
             * Check for any hashtags and save them
             */
            preg_match_all('/(^|\s)(#\w+)/', $this->input['body'], $hashtags);
            foreach ($hashtags[2] as $value) {
                $timeline = Timeline::where('username', str_replace('@', '', $value))->first();
                $hashtag = Hashtag::where('tag', str_replace('#', '', $value))->first();
                if ($hashtag) {
                    $hashtag->count = $hashtag->count + 1;
                    $hashtag->save();
                } else {
                    Hashtag::create(['tag' => str_replace('#', '', $value), 'count' => 1]);
                }
            }

            /**
             * Let us tag the post friends :)
             */
            if (array_key_exists('user_tags', $this->input)) {
                $user_tags = $this->input['user_tags'];
                if (!is_null($user_tags)) {
                    $post->usersTagged()->sync(explode(',', $user_tags));
                }
            }
        }

        /**
         * $post->users_tagged = $post->users_tagged();
         */
        return compact('post', 'timeline');
    }
}
