<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->get('forto_admin.authenticated')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', [
            'pageTitle' => 'Login',
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $normalizedEmail = strtolower(trim($credentials['email']));
        $user = null;

        try {
            $user = User::query()
                ->where('email', $normalizedEmail)
                ->first();
        } catch (Throwable) {
            $user = null;
        }

        $fallbackEmail = strtolower((string) config('forto.admin.email'));
        $fallbackPassword = (string) config('forto.admin.password');

        $isValid = $user
            ? Hash::check($credentials['password'], $user->password)
            : ($normalizedEmail === $fallbackEmail && hash_equals($fallbackPassword, $credentials['password']));

        if (! $isValid) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak cocok.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('forto_admin', [
            'authenticated' => true,
            'name' => $user?->name ?? (string) config('forto.admin.name', 'wtp'),
            'email' => $user?->email ?? $fallbackEmail,
            'logged_in_at' => now()->format('d M Y, H:i'),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Login berhasil')
            ->with('status_type', 'success')
            ->with('status', 'Login berhasil. Selamat datang di dashboard Porto.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('forto_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('status_title', 'Logout berhasil')
            ->with('status_type', 'info')
            ->with('status', 'Kamu sudah logout.');
    }
}
