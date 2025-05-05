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
        $employee = Auth::user();
        
        // Pastikan pengguna adalah seorang employee (role 3)
        if ($employee->role_id === 3) {
            // Ambil produk berdasarkan owner_id yang terkait dengan employee
            $products = Product::where('user_id', $employee->owner_id)  // owner_id adalah ID owner terkait
                ->select('id', 'name', 'stock', 'average_price', 'markup', 'selling_price')
                ->get();

            return response()->json($products);
        }

        // Jika pengguna bukan employee (role 3), beri respon error
        return response()->json(['message' => 'Akses ditolak.'], 403);
    }
    
    public function checkout(Request $request)
    {
        $order = $request->input('order');
        $paymentMethod = $request->input('payment_method');

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
                    'product_id' => $item['id'],
                    'product_name' => $item['name'], // Tambahkan ini
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
