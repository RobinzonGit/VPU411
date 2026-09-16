<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function profile(): View
    {
        return view('auth.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            // Удаляем предыдущий аватар, если он есть и файл существует
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            // чтобы случайно не перезаписать avatar на null
            unset($data['avatar']);
        }

        $user->update($data);

        return redirect()
            ->route('profile')
            ->with('status', 'Профиль успешно обновлён.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->update([
            'password' => $request->validated('password'),
        ]);

        return redirect()
            ->route('profile')
            ->with('status', 'Пароль успешно изменён.');
    }
}
