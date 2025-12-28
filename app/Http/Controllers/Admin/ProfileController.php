<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;

class ProfileController extends Controller
{
    /**
     * Profil admin
     */
    public function index()
    {
        return view('admin.profile.index', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email'
        ]);

        auth()->user()->update($request->only('name','email'));

        return back()->with('success', 'Profil diperbarui');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diganti');
    }
}
