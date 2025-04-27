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
        $request->validate([
            'code' => 'required|string|unique:products,code',
            'name' => 'required|string',
            'stock' => 'required|integer|min:1',
            'average_price' => 'required|numeric|min:0',
            'markup' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'stock' => $request->stock,
            'average_price' => $request->average_price,
            'markup' => $request->markup,
            'selling_price' => $request->selling_price,
        ]);

        return redirect()->route('employee.stock')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function index()
    {
        $products = Product::all();

        return Inertia::render('Employee/ProductList', [
            'products' => $products,
        ]);
    }
}
