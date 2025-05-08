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
        // Check if user is a stock employee or owner
        $user = auth()->user();
        if (($user->role_id === 3 && $user->employees_role === 'stock') || $user->role_id === 2) {
            return Inertia::render('Employee/AddProduct');
        }
        
        abort(403, 'Unauthorized access');
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

        // Get the current user
        $user = auth()->user();
        
        if ($user->role_id === 3 && $user->employees_role === 'stock' && $user->owner_id) {
            // If user is a stock employee, set the user_id to be the owner's ID
            $validated['user_id'] = $user->owner_id;
        } elseif ($user->role_id === 2) {
            // If user is an owner, set the user_id to their own ID
            $validated['user_id'] = $user->id;
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }
    

    public function index()
    {
        // Get the current logged-in user
        $user = auth()->user();
    
        if ($user->role_id === 3 && $user->employees_role === 'stock') {
            // If stock employee, filter products by the owner's ID
            $products = Product::where('user_id', $user->owner_id)->get();
        } elseif ($user->role_id === 2) {
            // If owner, show their own products
            $products = Product::where('user_id', $user->id)->get();
        } else {
            abort(403, 'Unauthorized access');
        }
    
        return Inertia::render('Employee/ProductList', [
            'products' => $products,
        ]);
    }
    
}