<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificatorController extends Controller
{
    public function dashboard()
    {
        // Pastikan hanya verifikator yang bisa mengakses
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda bukan verifikator');
        }
        
        // Ambil daftar pengguna yang belum disetujui (Owner)
        $pendingUsers = User::where('is_approved', false)
                           ->where('role_id', 2)
                           ->get();
                           
        return Inertia::render('Dashboard', [
            'pendingUsers' => $pendingUsers
        ]);
    }
    
    public function approveUser($id)
    {
        // Pastikan hanya verifikator yang bisa mengakses
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda bukan verifikator');
        }
        
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();
        
        return redirect()->back()->with('message', 'Pengguna berhasil disetujui');
    }
    
    public function rejectUser($id)
    {
        // Pastikan hanya verifikator yang bisa mengakses
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda bukan verifikator');
        }
        
        $user = User::findOrFail($id);
        $user->delete(); // Atau bisa juga tandai sebagai ditolak dengan kolom tambahan
        
        return redirect()->back()->with('message', 'Pengguna ditolak dan dihapus');
    }
    
    public function showOwner($id)
    {
        $owner = User::where('id', $id)->where('role_id', 2)->firstOrFail();
        
        return Inertia::render('Verificator/OwnerDetail', [
            'owner' => $owner
        ]);
    }
    
    
}