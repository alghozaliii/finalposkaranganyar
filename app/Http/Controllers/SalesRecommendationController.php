<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

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
            DB::raw('SUM(purchase.total_price) as total_sales')
        )
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_quantity');

    if ($month) {
        $query->whereMonth('purchase.created_at', $month);
    }

    if ($year) {
        $query->whereYear('purchase.created_at', $year);
    }

    $data = $query->get();

    return Inertia::render('Owner/SalesRecommendation', [
        'sales' => $data,
        'months' => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
        'years' => ['2023', '2024', '2025', '2026', '2027', '2028', '2029','2030','2031','2032','2033','2034','2035','2036','2037','2038','2039','2040'],
    ]);
}
}

