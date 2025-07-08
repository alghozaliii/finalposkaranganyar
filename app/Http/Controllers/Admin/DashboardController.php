<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all owners with their employees
        $owners = User::where('role_id', 2)
            ->with(['employees' => function($query) {
                $query->select('id', 'name', 'employees_role', 'owner_id');
            }])
            ->select('id', 'email', 'store_name', 'store_address', 'address', 'nik', 'phone', 'store_status')
            ->get();

        $totalOwners = $owners->count();
        
        return Inertia::render('Admin/AdminDashboard', [
            'totalOwners' => $totalOwners,
            'owners' => $owners
        ]);
    }

    public function updateStoreStatus(Request $request, $id)
    {
        $request->validate([
            'store_status' => 'required|in:aktif,nonaktif',
        ]);

        $owner = User::where('id', $id)->where('role_id', 2)->firstOrFail();
        $owner->store_status = $request->store_status;
        $owner->save();

        return back()->with('message', 'Status toko berhasil diperbarui.');
    }
}