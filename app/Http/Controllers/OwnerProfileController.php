<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class OwnerProfileController extends Controller
{
    public function uploadQrisPhoto(Request $request)
    {
        $request->validate([
            'qris_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = $request->user();

        // Hapus foto QRIS lama jika ada
        if ($user->qris_photo) {
            Storage::disk('public')->delete($user->qris_photo);
        }

        // Simpan file dengan nama unik
        $qrisFilename = time() . '_qris.' . $request->file('qris_photo')->getClientOriginalExtension();
        $qrisPath = $request->file('qris_photo')->storeAs('uploads/qris', $qrisFilename, 'public');

        $user->qris_photo = $qrisPath;
        $user->save();

        return redirect()->back()->with('message', 'Foto QRIS berhasil diunggah.');
    }
}
