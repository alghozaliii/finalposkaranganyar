<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
public function getProducts()
{
    // Mendapatkan pengguna yang sedang login
    $user = Auth::user();
    
    // Pastikan pengguna adalah seorang employee (role 3) atau owner (role 2)
    if ($user->role_id === 3) {
        // Jika employee, ambil produk berdasarkan owner_id yang terkait dengan employee
        $products = Product::where('user_id', $user->owner_id)
            ->where('is_active', true) // Hanya ambil produk yang aktif
            ->select('id', 'code', 'name', 'stock', 'average_price', 'selling_price', 'profit', 'category', 'unit')
            ->get();

        return response()->json($products);
    } 
    elseif ($user->role_id === 2) {
        // Jika owner, ambil produk miliknya sendiri
        $products = Product::where('user_id', $user->id)
            ->where('is_active', true) // Hanya ambil produk yang aktif
            ->select('id', 'code', 'name', 'stock', 'average_price', 'selling_price', 'profit', 'category', 'unit')
            ->get();

        return response()->json($products);
    }

    // Jika bukan employee atau owner, beri respon error
    return response()->json(['message' => 'Akses ditolak.'], 403);
}
    
    public function checkout(Request $request)
    {
        $order = $request->input('order');
        $paymentMethod = $request->input('payment_method');
        $invoiceNumber = $request->input('invoice_number');

        DB::beginTransaction();
        try {
            // Update stok produk
            foreach ($order as $item) {
                DB::table('products')
                    ->where('id', $item['id'])
                    ->decrement('stock', $item['quantity']);
            }

            // Masukkan transaksi ke tabel purchase
            foreach ($order as $item) {
                DB::table('purchase')->insert([
                    'invoice_number' => $invoiceNumber,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['quantity'] * $item['selling_price'],
                    'payment_method' => $paymentMethod,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);                                
            }

            DB::commit();
            return response()->json(['message' => 'Pembayaran berhasil!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal memproses pembayaran.'], 500);
        }
    }
}
