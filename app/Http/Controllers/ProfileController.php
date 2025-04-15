<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('frontend.profile',compact('user'));
    }

    public function posts(){
        $user = Auth::user();
        $postids=$user->favourites->map(fn($list) => $list->pivot->post_id)->toArray();
        $posts= Post::whereIn('id',$postids)->get();
        return view('frontend.favourites',compact('user','posts'));
    }
}
