<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

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

    Product::create($validated);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
}
    

    public function index()
    {
        $products = Product::all();

        return Inertia::render('Employee/ProductList', [
            'products' => $products,
        ]);
    }
}
