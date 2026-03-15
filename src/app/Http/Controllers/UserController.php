<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller

{
    public function create()
    {
        return view('auth.register');
    }

    // tworzenie nowego użytkownika
    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required'],
            'email'      => ['required', 'unique:users,email'],
            'password'   => ['required', Password::min(6), 'confirmed']
        ]);

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('/');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user = User::findOrFail(Auth::id());
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'], // Walidacja hex koloru
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'], // Max 2MB
        ]);

        // Obsługa Logo
        if ($request->hasFile('logo')) {
            // 1. Usuń stare logo, jeśli istnieje
            if ($user->logo_path) {
                Storage::disk('public')->delete($user->logo_path);
            }

            // 2. Zapisz nowe logo w folderze 'logos' w dysku public
            $path = $request->file('logo')->store('logos', 'public');
            $user->logo_path = $path;
        }

        // Aktualizacja pozostałych pól
        $user->name = $attributes['name'];
        $user->brand_color = $attributes['brand_color'];
        $user->save();

        return back()->with('success', 'Ustawienia zostały zaktualizowane!');
    }
}
