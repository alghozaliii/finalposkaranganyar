<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStockHistory;

class ProductController extends Controller
{
    public function create()
    {
        // Check if user is a stock employee or owner
        /** @var \App\Models\User $user */
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

    /** @var \App\Models\User $user */
    $user = auth()->user();
    $user_id_for_product = null;
    if ($user->role_id === 3 && $user->employees_role === 'stock' && $user->owner_id) {
        $user_id_for_product = $user->owner_id;
    } elseif ($user->role_id === 2) {
        $user_id_for_product = $user->id;
    }

    $validated['user_id'] = $user_id_for_product;
    // Hitung profit per produk
    $validated['profit'] = $validated['selling_price'] - $validated['average_price'];
    $validated['status'] = 'active';

    // Cek apakah produk dengan kode sama sudah ada
    $existing = Product::where('code', $validated['code'])
        ->where('user_id', $user_id_for_product)
        ->first();

    $old_stock = 0;
    $type = 'initial';

    if ($existing) {
        $old_stock = $existing->stock;
        // Update stok dan harga
        $existing->stock += $validated['stock'];
        $existing->average_price = $validated['average_price'];
        $existing->selling_price = $validated['selling_price'];
        $existing->profit = $validated['profit'];
        $existing->category = $validated['category'];
        $existing->unit = $validated['unit'];
        $existing->save();
        $product = $existing; // Set product to existing for history logging
        $type = 'add';
    } else {
        $product = Product::create($validated);
    }

    // Log stock history
    ProductStockHistory::create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'old_stock' => $old_stock,
        'new_stock' => $product->stock,
        'change_amount' => $validated['stock'],
        'type' => $type,
        'notes' => 'Stock ' . ($type === 'initial' ? 'added initially' : 'increased') . ' through add product form.',
    ]);

    return redirect()->back()->with('success', 'Produk berhasil disimpan');
}
    

        public function index()
        {
            /** @var \App\Models\User $user */
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
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (!$user || $user->role_id !== 2) {
            return response()->json([
                'message' => 'Hanya owner yang dapat mengedit produk'
            ], 403);
        }

        $product = Product::findOrFail($id);

        // Verify owner owns this product
        if ($product->user_id !== $user->id) {
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

        $old_stock = $product->stock;

        // Hitung ulang profit
        $validated['profit'] = $validated['selling_price'] - $validated['average_price'];

        $product->update($validated);

        $new_stock = $product->stock;
        $change_amount = $new_stock - $old_stock;

        // Log stock history if stock has changed
        if ($change_amount !== 0) {
            ProductStockHistory::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'old_stock' => $old_stock,
                'new_stock' => $new_stock,
                'change_amount' => $change_amount,
                'type' => ($change_amount > 0 ? 'add' : 'deduct'),
                'notes' => 'Stock adjusted via edit product form.',
            ]);
        }

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'product' => $product
        ]);
    }
    public function check(Request $request)
{
    $code = $request->query('code');
    /** @var \App\Models\User $user */
    $user = auth()->user();
    $product = Product::where('code', $code)
        ->where('user_id', $user->role_id === 3 ? $user->owner_id : $user->id)
        ->first();
    return response()->json(['product' => $product]);
}

    public function showStockHistory()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $userId = null;

        if ($user->role_id === 3 && $user->employees_role === 'stock') {
            $userId = $user->owner_id;
        } elseif ($user->role_id === 2) {
            $userId = $user->id;
        } else {
            abort(403, 'Unauthorized access');
        }

        $stockHistories = \App\Models\ProductStockHistory::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with('product')
        ->orderByDesc('created_at')
        ->get();

        // Get all products related to this user to pass to the frontend for mapping product IDs to names
        $products = \App\Models\Product::where('user_id', $userId)->get();

        return Inertia::render('Employee/ProductStockHistory', [
            'stockHistories' => $stockHistories,
            'products' => $products // Pass products as an array, not mapped
        ]);
    }
}