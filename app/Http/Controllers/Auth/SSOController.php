<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SSOService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class SSOController extends Controller
{
    protected $ssoService;

    public function __construct(SSOService $ssoService)
    {
        $this->ssoService = $ssoService;
    }

    public function redirect()
    {
        $state = bin2hex(random_bytes(16));
        Session::put('sso_state', $state);

        $params = [
            'response_type' => 'code',
            'client_id' => $this->ssoService->getClientId(),
            'redirect_uri' => $this->ssoService->getRedirectURL(),
            'scopes' => 'user',
            'state' => $state
        ];

        $url = $this->ssoService->getAuthorizeURL() . '?' . http_build_query($params);
        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        if (!$this->ssoService->validateState($request->state)) {
            return redirect()->route('login')->with('error', 'Invalid state parameter');
        }

        $token = $this->ssoService->getAccessToken($request->code);
        if (!isset($token['access_token'])) {
            return redirect()->route('login')->with('error', 'Failed to get access token');
        }

        $userInfo = $this->ssoService->getUserInfo($token['access_token']);
        
        // Check if user exists in our database
        $user = User::where('email', $userInfo['email'])->first();

        if (!$user) {
            // User doesn't exist, redirect to store registration
            return Inertia::render('Auth/RegisterStore', [
                'ssoUser' => $userInfo
            ]);
        }

        // Check if user is approved
        if (!$user->is_approved) {
            return redirect()->route('login')->with('error', 'Akun Anda masih menunggu persetujuan dari verifikator.');
        }

        // Check if user is an owner
        if ($user->role_id === 2) { // Assuming 2 is the role_id for owners
            if (!$user->store_name) {
                // Owner without store, redirect to store registration
                return Inertia::render('Auth/RegisterStore', [
                    'ssoUser' => $userInfo
                ]);
            }
            
            // Owner with store, redirect to owner dashboard
            Auth::login($user);
            return redirect()->route('owner.dashboard');
        }

        // For other roles (employee, verifikator)
        Auth::login($user);
        return redirect()->intended();
    }

    public function registerStore(Request $request)
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

        try {
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
        } catch (\Exception $e) {
            Log::error('Store registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }
} 