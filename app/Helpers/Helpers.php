<?php

/*
 * This file is part of Medlib.
 *
 * Copyright (C) 2016 Medlib.fr
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
