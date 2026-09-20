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
        $user = auth()->user();
       $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if (isset($validated['avatar'])) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->email = $validated['email'];
        $user->name = $validated['name'];
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
