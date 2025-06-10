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
        'code' => 'required',
        'name' => 'required',
        'stock' => 'required|integer|min:1',
        'average_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'category' => 'nullable|string',
        'unit' => 'nullable|string',
    ]);

    $user = auth()->user();
    if ($user->role_id === 3 && $user->employees_role === 'stock' && $user->owner_id) {
        $validated['user_id'] = $user->owner_id;
    } elseif ($user->role_id === 2) {
        $validated['user_id'] = $user->id;
    }

    // Hitung profit per produk
    $validated['profit'] = $validated['selling_price'] - $validated['average_price'];
    $validated['status'] = 'active';

    // Cek apakah produk dengan kode sama sudah ada
    $existing = \App\Models\Product::where('code', $validated['code'])
        ->where('user_id', $validated['user_id'])
        ->first();

    if ($existing) {
        // Update stok dan harga
        $existing->stock += $validated['stock'];
        $existing->average_price = $validated['average_price'];
        $existing->selling_price = $validated['selling_price'];
        $existing->profit = $validated['profit'];
        $existing->category = $validated['category'];
        $existing->unit = $validated['unit'];
        $existing->save();
    } else {
        \App\Models\Product::create($validated);
    }

    return redirect()->back()->with('success', 'Produk berhasil disimpan');
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
    
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'status' => $product->is_active ? 'active' : 'inactive',
            'message' => 'Status produk berhasil diubah'
        ]);
    }

    public function update(Request $request, $id)
    {
        // Check if user is owner
        if (auth()->user()->role_id !== 2) {
            return response()->json([
                'message' => 'Hanya owner yang dapat mengedit produk'
            ], 403);
        }

        $product = Product::findOrFail($id);

        // Verify owner owns this product
        if ($product->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk mengedit produk ini'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required',
            'stock' => 'required|integer',
            'average_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'category' => 'nullable|string',
            'unit' => 'nullable|string',
        ]);

        // Hitung ulang profit
        $validated['profit'] = $validated['selling_price'] - $validated['average_price'];

        $product->update($validated);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'product' => $product
        ]);
    }
    public function check(Request $request)
{
    $code = $request->query('code');
    $user = auth()->user();
    $product = Product::where('code', $code)
        ->where('user_id', $user->role_id === 3 ? $user->owner_id : $user->id)
        ->first();
    return response()->json(['product' => $product]);
}
}