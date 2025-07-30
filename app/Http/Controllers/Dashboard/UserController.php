<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  public function index()
  {
    $users = User::with('role')->latest()->paginate(10);
    return view('dashboard.users.index', compact('users'));
  }

  public function create()
  {
    $roles = Role::all();
    return view('dashboard.users.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'role_id' => 'required|exists:roles,id',
      'phone' => 'nullable|string|max:20',
      'date_of_birth' => 'nullable|date',
      'gender' => 'nullable|in:Laki-laki,Perempuan',
      'address' => 'nullable|string|max:500',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $userData = $request->except(['password', 'password_confirmation', 'photo']);
    $userData['password'] = Hash::make($request->password);

    if ($request->hasFile('photo')) {
      $userData['photo'] = $request->file('photo')->store('users', 'public');
    }

    User::create($userData);

    return redirect()->route('dashboard.users.index')
      ->with('success', 'User berhasil dibuat.');
  }

  public function show(User $user)
  {
    $user->load('role');
    return view('dashboard.users.show', compact('user'));
  }

  public function edit(User $user)
  {
    $roles = Role::all();
    return view('dashboard.users.edit', compact('user', 'roles'));
  }

  public function update(Request $request, User $user)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
      'password' => 'nullable|string|min:8|confirmed',
      'role_id' => 'required|exists:roles,id',
      'phone' => 'nullable|string|max:20',
      'date_of_birth' => 'nullable|date',
      'gender' => 'nullable|in:Laki-laki,Perempuan',
      'address' => 'nullable|string|max:500',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $userData = $request->except(['password', 'password_confirmation', 'photo']);

    if ($request->filled('password')) {
      $userData['password'] = Hash::make($request->password);
    }

    if ($request->hasFile('photo')) {
      // Delete old photo if exists
      if ($user->photo) {
        Storage::disk('public')->delete($user->photo);
      }
      $userData['photo'] = $request->file('photo')->store('users', 'public');
    }

    $user->update($userData);

    return redirect()->route('dashboard.users.index')
      ->with('success', 'User berhasil diupdate.');
  }

  public function destroy(User $user)
  {
    // Prevent admin from deleting themselves
    if ($user->id === auth()->id()) {
      return redirect()->route('dashboard.users.index')
        ->with('error', 'Anda tidak bisa menghapus akun sendiri.');
    }

    // Delete photo if exists
    if ($user->photo) {
      Storage::disk('public')->delete($user->photo);
    }

    $user->delete();

    return redirect()->route('dashboard.users.index')
      ->with('success', 'User berhasil dihapus.');
  }
}
