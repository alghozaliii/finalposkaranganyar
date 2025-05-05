<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function create()
    {
        return Inertia::render('Employee/AddProduct');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required',
            'stock' => 'required|integer',
            'average_price' => 'required|numeric',
            'markup' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'category' => 'nullable|string',
            'unit' => 'nullable|string',
        ]);

        // Get the current employee
        $employee = auth()->user();
        
        // If this is a stock employee, get their owner's ID
        if ($employee->role_id === 3 && $employee->employees_role === 'stock' && $employee->owner_id) {
            // Set the user_id to be the owner's ID
            $validated['user_id'] = $employee->owner_id;
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }
    

    public function index()
    {
        // Get the current logged-in user
        $employee = auth()->user();
    
        // Filter products by the owner's ID
        $products = Product::where('user_id', $employee->owner_id)->get();
    
        return Inertia::render('Employee/ProductList', [
            'products' => $products,
        ]);
    }
    
}