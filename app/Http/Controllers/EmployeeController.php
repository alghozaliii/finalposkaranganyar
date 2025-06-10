<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Tampilkan daftar pegawai untuk Owner
     */
    public function index()
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Only owners can access this page');
        }
        
        // Redirect to owner dashboard instead
        return redirect()->route('owner.dashboard');
    }
    
    /**
     * Tambah Pegawai Baru dengan Role (Cashier atau Stock)
     */
    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Only owners can register employees');
        }
        
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'employees_role' => 'required|in:cashier,stock'
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->username, // Set name same as username
            'email' => $request->username . '@sikara.com', // Add email using username
            'password' => Hash::make($request->password),
            'role_id' => 3,
            'employees_role' => $request->employees_role,
            'owner_id' => auth()->id(),
            'is_approved' => true
        ]);

        return redirect()->back();
    }
    
    /**
     * Hapus Pegawai
     */
    public function destroy($id)
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Only owners can remove employees');
        }
        
        $employee = User::where('id', $id)
                        ->where('owner_id', auth()->id())
                        ->where('role_id', 3)
                        ->firstOrFail();
        
        // Force delete untuk menghapus data secara permanen
        $employee->forceDelete();
        
        return redirect()->back()->with('success', 'Employee successfully removed.');
    }
    
    /**
     * Tampilkan Dashboard Pegawai
     */
    public function dashboard()
    {
        if (auth()->user()->role_id !== 3) {
            abort(403, 'Only employees can access this page');
        }
        
        $owner = User::find(auth()->user()->owner_id);
        
        return Inertia::render('Employee/Dashboard', [
            'owner' => $owner
        ]);
    }

    /**
     * Tampilkan Halaman Kasir
     */
    public function cashier()
    {
        if (auth()->user()->role_id !== 3 || auth()->user()->employees_role !== 'cashier') {
            abort(403, 'Only cashiers can access this page');
        }
        
        $user = auth()->user();
        
        // Get the store name from the owner
        if ($user->owner_id) {
            $owner = \App\Models\User::find($user->owner_id);
            if ($owner && $owner->store_name) {
                $user->store_name = $owner->store_name;
            }
        }
    
        return Inertia::render('Employee/Cashier');
    }
    
    /**
     * Tampilkan Halaman Manajemen Stok
     */
    public function stock()
    {
        if (auth()->user()->role_id !== 3 || auth()->user()->employees_role !== 'stock') {
            abort(403, 'Only stock admins can access this page');
        }
        
        $user = auth()->user();
        
        // Get the store name from the owner
        if ($user->owner_id) {
            $owner = \App\Models\User::find($user->owner_id);
            if ($owner && $owner->store_name) {
                $user->store_name = $owner->store_name;
            }
        }
    
        return Inertia::render('Employee/StockManagement', [
            'addProductRoute' => route('employee.stock.add'), // Kirim route ke Vue
            'listProductsRoute' => route('employee.stock.products')
        ]);
    }
    
    /**
     * Tampilkan Form Tambah Produk (Hanya Admin Stok)
     */
    public function addProduct()
    {
        if (auth()->user()->role_id !== 3 || auth()->user()->employees_role !== 'stock') {
            abort(403, 'Only stock admins can add products');
        }

        return Inertia::render('Employee/AddProduct');
    }

    public function getSalesHistory()
    {
        $sales = \DB::table('purchase')->orderBy('created_at', 'desc')->get();
        return response()->json($sales);
    }    

    /**
     * Tampilkan Halaman Kasir untuk Owner
     */
    public function ownerCashier()
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Only owners can access this page');
        }
        
        $user = auth()->user();
    
        return Inertia::render('Employee/Cashier');
    }
    
    /**
     * Tampilkan Halaman Manajemen Stok untuk Owner
     */
    public function ownerStock()
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Only owners can access this page');
        }
        
        $user = auth()->user();
    
        return Inertia::render('Employee/StockManagement', [
            'addProductRoute' => route('owner.stock.add'), // Kirim route ke Vue
            'listProductsRoute' => route('owner.stock.products')
        ]);
    }

    /**
     * Tampilkan Dashboard Owner
     */
    public function ownerDashboard()
    {
        if (auth()->user()->role_id !== 2) {
            abort(403, 'Only owners can access this page');
        }
        
        // Get employees for this owner
        $employees = User::where('owner_id', auth()->id())
                         ->where('role_id', 3)
                         ->select('id', 'name', 'email', 'employees_role', 'created_at')
                         ->get()
                         ->map(function($employee) {
                             return [
                                 'id' => $employee->id,
                                 'name' => $employee->name,
                                 'email' => $employee->email,
                                 'employees_role' => $employee->employees_role,
                                 'created_at' => $employee->created_at->format('d/m/Y H:i'),
                             ];
                         });

        return Inertia::render('OwnerDashboard', [
            'employees' => $employees,
            'initialPage' => 'dashboard'
        ]);
    }
}
