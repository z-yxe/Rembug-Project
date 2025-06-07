<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // fungsi menampilkan daftar postingan
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    // fungsi membuat postingan baru
    public function create()
    {
        return view('posts.create');
    }

    // fungsi menyimpan postingan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image_path' => $imagePath,
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    // fungsi menampilkan postingan
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // fungsi mengedit postingan
    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    // fungsi memperbarui postingan
    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'caption' => 'required',
        ]);

        $post->update($data);

        return redirect('/posts/' . $post->id);
    }

    // fungsi menghapus postingan
    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($post->image_path);
        $post->delete();

        return redirect('/profile/' . auth()->user()->id);
    }

    // fungsi pencarian postingan dan user
    public function search(Request $request)
    {
        $query = $request->input('q');
        $postResults = null;
        $userResults = null;

        if ($query) {
            $postResults = Post::where('caption', 'LIKE', "%{$query}%")
                ->with('user')
                ->latest()
                ->paginate(10, ['*'], 'posts_page');

            $userResults = User::where('username', 'LIKE', "%{$query}%")
                ->orWhere('name', 'LIKE', "%{$query}%")
                ->paginate(10, ['*'], 'users_page');
        }

        return view('search.index', compact('query', 'postResults', 'userResults'));
    }
}
