<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function index_login()
    {
        return view('auth.login');
    }

    public function user_profile_index()
    {
        return view('customer.user_profile');
    }

    public function admin_profile_index()
    {
        return view('admin.admin_profile');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'regex:/^(\+27|27|0)[6-8][0-9]{8}$/'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'phone.regex' => 'Enter a valid SA number e.g. 0721234567, 27721234567, or +27721234567.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect('/home')->with('success', 'Welcome to Fornoria ' . $user->name);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard')->with('success', 'Welcome back ' . $user->name);
            }

            return redirect()->intended('/home')->with('success', 'Welcome back ' . $user->name);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not exist.']);
    }

    public function edit_profile(Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'regex:/^(\+27|27|0)[6-8][0-9]{8}$/'],
        ], [
            'phone.regex' => 'Enter a valid SA number e.g. 0721234567, 27721234567, or +27721234567.',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function change_password(Request $request) {

        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            return redirect()->back()->with('error', 'Password is incorrect');
        }

        $validated = $request->validate([
            'newPassword' => ['required', 'string', 'min:8'],
        ]);

        $user->password = Hash::make($validated['newPassword']);
        $user->save();

        return redirect()->back()->with('success', 'Password Updated Successfully');
    }

    public function admin_add_index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.add_admin', compact('admins'));
    }

    public function admin_store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'regex:/^(\+27|27|0)[6-8][0-9]{8}$/'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'phone.regex' => 'Enter a valid SA number e.g. 0721234567, 27721234567, or +27721234567.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.add.index')->with('success', 'Admin added successfully.');
    }

    public function delete_user($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.add.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Admin deleted successfully.');
    }

    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/register')->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make(Str::password(12)),
                'role' => 'user',
            ]
        );

        Auth::login($user);

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
