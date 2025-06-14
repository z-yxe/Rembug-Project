<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // fungsi like post
    public function store(Post $post)
    {
        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    // fungsi unlike post
    public function destroy(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        return back();
    }
}