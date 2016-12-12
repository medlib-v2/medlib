<?php

namespace Medlib\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Medlib\Http\Controllers\Controller;
use Medlib\Models\User;

class SearchUserController extends Controller
{

    /**
    public function appendValue($data, $type, $element)
    {
        // operate on the item passed by reference, adding the element and type
        foreach ($data as $key => & $item) {
            $item[$element] = $type;
        }
        return $data;
    }

    public function appendURL($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix.'/'.$item['slug']);
        }
        return $data;
    }
    */

    public function getResults()
    {
        $term = e(Input::get('q', ''));

        //if(!$term && $term == '') return Response::json(array(), 400);

        if (!$term && $term == '') {
            return Redirect::back();
        }

        $results = [];

        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$term}%")
            ->orWhere('username', 'LIKE', "%{$term}%")
            ->orderBy('username', 'asc')
            ->get(['first_name','last_name','user_avatar']);

        /**
         *
         * $users = User::table('users')
        ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$term}%")
        ->orWhere('username', 'LIKE', "%{$term}%")
        ->orderBy('username','asc')
        ->take(5)->get(['first_name','last_name','user_avatar']);

        $categories = Category::where('name','like','%'.$query.'%')
        ->has('products')
        ->take(5)
        ->get(array('slug', 'name'))
        ->toArray();

        foreach ($users as $user)
        {
        $results[] = [ 'value' => $user->first_name.' '.$user->last_name, 'avatar' => $user->user_avatar ];
        }
         */

        return view('dashboard.search-users')->with('users', $users);
    }
}
