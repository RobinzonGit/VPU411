<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('auth.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
       $path = $request->file('avatar')->store('avatars', 'public');

    }
}
