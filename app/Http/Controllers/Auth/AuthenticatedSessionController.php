<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Proses autentikasi login.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Try to authenticate using either email or username
        if (!Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']], $request->filled('remember')) &&
            !Auth::attempt(['username' => $credentials['login'], 'password' => $credentials['password']], $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        // Jika akun belum disetujui
        if (!$user->is_approved) {
            Auth::logout();
            return redirect('/')->with('message', 'Akun Anda masih menunggu persetujuan.');
        }

        // **LOGIKA REDIRECT BERDASARKAN ROLE**
        if ($user->role_id === 1) {
            return redirect()->route('verificator.dashboard');
        } elseif ($user->role_id === 2) {
            return redirect()->route('owner.dashboard');
        } elseif ($user->role_id === 3) {
            if ($user->employees_role === 'cashier') {
                return redirect()->route('employee.cashier');
            } elseif ($user->employees_role === 'stock') {
                return redirect()->route('employee.stock');
            }
            return redirect()->route('employee.dashboard');
        }

        return redirect('/dashboard');
    }

    /**
     * Logout user.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
