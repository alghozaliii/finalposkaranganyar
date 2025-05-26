<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Profit;

class SalesRecommendationController extends Controller
{
    public function index(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');

    $query = DB::table('purchase')
        ->join('products', 'purchase.product_id', '=', 'products.id')
        ->select(
            'products.name as product_name',
            DB::raw('SUM(purchase.quantity) as total_quantity'),
            DB::raw('SUM(purchase.total_price) as total_sales'),
            'products.profit as profit_per_product'
        )
        ->groupBy('products.id', 'products.name', 'products.profit')
        ->orderByDesc('total_quantity');

    if ($month) {
        $query->whereMonth('purchase.created_at', $month);
    }
    if ($year) {
        $query->whereYear('purchase.created_at', $year);
    }

    $data = $query->get();

    // Simpan ke tabel profit (auto insert/update)
    foreach ($data as $item) {
        Profit::updateOrCreate(
            [
                'product_name' => $item->product_name,
                // Jika ingin unik per bulan/tahun, tambahkan filter bulan/tahun di sini
            ],
            [
                'total_quantity' => $item->total_quantity,
                'profit_per_product' => $item->profit_per_product,
                'total_profit' => $item->profit_per_product * $item->total_quantity,
                'total_sales' => $item->total_sales,
            ]
        );
    }

    return Inertia::render('Owner/SalesRecommendation', [
        'sales' => $data,
        'years' => ['2023', '2024', '2025', '2026', '2027', '2028', '2029','2030','2031','2032','2033','2034','2035','2036','2037','2038','2039','2040'],
    ]);
}
public function storeProfit(Request $request)
{
    $data = $request->validate([
        'profits' => 'required|array',
        'profits.*.product_name' => 'required|string',
        'profits.*.total_quantity' => 'required|integer',
        'profits.*.profit_per_product' => 'required|numeric',
        'profits.*.total_profit' => 'required|numeric',
        'profits.*.total_sales' => 'nullable|numeric',
    ]);

    foreach ($data['profits'] as $profit) {
        Profit::create($profit);
    }

    return response()->json(['message' => 'Data profit berhasil disimpan']);
}
}

