<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of registered users (non-admin).
     */
    public function index()
    {
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Approve a user registration.
     */
    public function approve(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', "User {$user->name} berhasil disetujui.");
    }

    /**
     * Reject (unapprove) a user.
     */
    public function reject(User $user)
    {
        $user->is_approved = false;
        $user->save();

        return redirect()->back()->with('success', "User {$user->name} berhasil ditolak.");
    }

    /**
     * Delete a user account.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
