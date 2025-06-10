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
            ->select('id', 'email', 'store_name')
            ->get();

        $totalOwners = $owners->count();
        
        return Inertia::render('Admin/AdminDashboard', [
            'totalOwners' => $totalOwners,
            'owners' => $owners
        ]);
    }
}