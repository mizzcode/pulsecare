<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'birthdate' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:Pria,Wanita'],
            'phone' => ['nullable', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Assign patient role by default
        $patientRole = Role::where('name', 'pasien')->first();
        $validated['role_id'] = $patientRole ? $patientRole->id : null;

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
