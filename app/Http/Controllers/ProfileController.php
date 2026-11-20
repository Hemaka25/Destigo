<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view('user.profile', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:50',
            'currency' => 'nullable|string|max:20',
        ]);

        $user->update($data);

        return redirect('/profile')->with('success', 'Profile updated.');
    }
}