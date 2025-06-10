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
        $totalOwners = User::where('role_id', 2)->count();
        
        return Inertia::render('Admin/AdminDashboard', [
            'totalOwners' => $totalOwners
        ]);
    }
} 