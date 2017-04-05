<?php

/*
 * This file is part of Medlib.
 *
 * Copyright (C) 2016 Medlib.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Medlib\Models\Page;
use Medlib\Models\User;
use Medlib\Models\Group;
use Medlib\Models\Hashtag;
use Medlib\Models\Setting;
use Illuminate\Support\Facades\Request;

if (!function_exists('set_active')) {
    /**
     * Set active class if request is in path.
     *
     * @param string $path
     * @param array  $classes
     * @param string $active
     *
     * @return string
     */
    function set_active($path, array $classes = [], $active = 'active')
    {
        if (Request::is($path)) {
            $classes[] = $active;
        }
        $class = e(implode(' ', $classes));
        return empty($classes) ? '' : "class=\"{$class}\"";
    }
}

if (!function_exists('cdn')) {
    /**
    * Creates CDN assets url
    *
    * @param string $path
    * @param null $secure
    * @return string
    */
    function cdn($path, $secure = null)
    {
        if (!config('medlib.cdn.url')) {
            return elixir($path);
        }
        $path = trim($path, '/');
        if (in_array(pathinfo($path, PATHINFO_EXTENSION), ['css', 'js'])) {
            $path = elixir($path);
        }
        return '//' . config('medlib.cdn.url') . ($path[0] !== '/' ? ('/' . $path) : $path);
    }
}

if (!function_exists('trending_tags')) {
    /**
     * @return string
     */
    function trending_tags()
    {
        $trending_tags = Hashtag::orderBy('count', 'desc')->get();

        if (count($trending_tags) > 0) {
            if (count($trending_tags) > (int) Setting::get('min_items_page', 3)) {
                $trending_tags = $trending_tags->random((int) Setting::get('min_items_page', 3));
            }
        } else {
            $trending_tags = '';
        }

        return $trending_tags;
    }
}

if (!function_exists('suggested_users')) {
    /**
     * @return string
     */
    function suggested_users()
    {
        $suggested_users = User::whereNotIn('id', Auth::user()->following()->get()->pluck('id'))->where('id', '!=', Auth::user()->id)->get();

        if (count($suggested_users) > 0) {
            if (count($suggested_users) > (int) Setting::get('min_items_page', 3)) {
                $suggested_users = $suggested_users->random((int) Setting::get('min_items_page', 3));
            }
        } else {
            $suggested_users = '';
        }

        return $suggested_users;
    }
}

if (!function_exists('suggested_groups')) {
    /**
     * @return string
     */
    function suggested_groups()
    {
        $suggested_groups = Group::whereNotIn('id', Auth::user()->groups()->pluck('group_id'))->where('type', 'open')->get();

        if (count($suggested_groups) > 0) {
            if (count($suggested_groups) > (int) Setting::get('min_items_page', 3)) {
                $suggested_groups = $suggested_groups->random((int) Setting::get('min_items_page', 3));
            }
        } else {
            $suggested_groups = '';
        }

        return $suggested_groups;
    }
}

if (!function_exists('suggested_pages')) {
    /**
     * @return string
     */
    function suggested_pages()
    {
        $suggested_pages = Page::whereNotIn('id', Auth::user()->pageLikes()->pluck('page_id'))->whereNotIn('id', Auth::user()->pages()->pluck('page_id'))->get();

        if (count($suggested_pages) > 0) {
            if (count($suggested_pages) > (int) Setting::get('min_items_page', 3)) {
                $suggested_pages = $suggested_pages->random((int) Setting::get('min_items_page', 3));
            }
        } else {
            $suggested_pages = '';
        }

        return $suggested_pages;
    }
}

if (!function_exists('settings')) {
    /**
     * Get settings
     *
     * @param string $key
     * @param string $default
     * @return \Illuminate\Database\Eloquent\Collection|string
     */
    function settings($key, $default = '')
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('app_version')) {
    /**
     * Returns the current app version from the file in the root of the project
     *
     * @return string
     */
    function app_version()
    {
        /**
         * Get the path to the version file.
         */
        $filename = __DIR__ .'../../../VERSION';

        /**
         * Return the content as a string
         */
        return (string) trim(file_get_contents($filename));
    }
}
