<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // fungsi untuk mencari pengguna
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('search.results', ['users' => collect()]);
        }

        $users = User::where('username', 'regexp', "/.*{$query}.*/i")
                     ->orWhere('name', 'regexp', "/.*{$query}.*/i")
                     ->get();

        return view('search.results', compact('users', 'query'));
    }
}