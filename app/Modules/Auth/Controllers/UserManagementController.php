<?php

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,user'],
        ]);

        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak bisa mengubah role akun sendiri.');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
