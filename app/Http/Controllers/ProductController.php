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
        'selling_price' => 'required|numeric',
        'category' => 'nullable|string',
        'unit' => 'nullable|string',
    ]);

    // Hitung profit (keuntungan per produk)
    $validated['profit'] = $validated['selling_price'] - $validated['average_price'];

    // Get the current user
    $user = auth()->user();
    if ($user->role_id === 3 && $user->employees_role === 'stock' && $user->owner_id) {
        $validated['user_id'] = $user->owner_id;
    } elseif ($user->role_id === 2) {
        $validated['user_id'] = $user->id;
    }

    Product::create($validated);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
}
    

        public function index()
        {
            $user = auth()->user();
            
            if ($user->role_id === 3 && $user->employees_role === 'stock') {
                $products = Product::where('user_id', $user->owner_id)->get();
            } elseif ($user->role_id === 2) {
                $products = Product::where('user_id', $user->id)->get();
            } else {
                abort(403, 'Unauthorized access');
            }

            return response()->json([
                'products' => $products
            ]);
            
       return Inertia::render('Employee/StockManagement', [
        'products' => $products,
        'addProductRoute' => route('employee.stock.create'),
        'listProductsRoute' => route('employee.stock.products')
    ]);
    }
    
}