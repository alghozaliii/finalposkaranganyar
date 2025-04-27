<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'store_name' => 'required|string|max:255',
            'address' => 'required|string',
            'nik' => 'required|string|unique:users,nik',
            'phone' => 'required|string|max:15',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selfie_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file dengan nama unik
        $ktpFilename = time() . '_ktp.' . $request->file('ktp_photo')->getClientOriginalExtension();
        $selfieFilename = time() . '_selfie.' . $request->file('selfie_photo')->getClientOriginalExtension();

        // Simpan ke storage
        $ktpPath = $request->file('ktp_photo')->storeAs('uploads/ktp', $ktpFilename, 'public');
        $selfiePath = $request->file('selfie_photo')->storeAs('uploads/selfie', $selfieFilename, 'public');

        // Buat user dengan role Owner (2), tapi belum di-approve
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Role Owner
            'is_approved' => false, // Harus disetujui dulu oleh verifikator
            'store_name' => $request->store_name,
            'address' => $request->address,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'ktp_photo' => $ktpPath,
            'selfie_photo' => $selfiePath,
        ]);

        // Event pendaftaran
        event(new Registered($user));

        // Jangan langsung login, karena harus menunggu persetujuan verifikator
        return redirect('/')->with('message', 'Akun Anda sedang menunggu konfirmasi oleh verifikator.');
    }
}
