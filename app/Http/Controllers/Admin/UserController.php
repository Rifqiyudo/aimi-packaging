<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    /**
     * Daftar user
     */
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::latest()->get()
        ]);
    }

    /**
     * Detail user
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user->load('orders')
        ]);
    }

    /**
     * Update role user
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,karyawan,pelanggan'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'Role user diperbarui');
    }

    /**
     * Reset password user
     */
    public function resetPassword(User $user)
    {
        $user->update([
            'password' => Hash::make('password123')
        ]);

        return back()->with('success', 'Password direset');
    }
}
