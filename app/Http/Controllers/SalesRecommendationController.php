<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\Profit;
use Illuminate\Support\Facades\Auth;
// Import Export class if needed, assuming it's something like:
// use App\Exports\SalesRecommendationExport;

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
            ->where('products.user_id', auth()->id())
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

    // Assuming this method exists for CSV export
    public function exportCSV(Request $request)
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
            ->where('products.user_id', auth()->id()) // Filter by authenticated owner's ID
            ->groupBy('products.id', 'products.name', 'products.profit')
            ->orderByDesc('total_quantity');

        if ($month) {
            $query->whereMonth('purchase.created_at', $month);
        }
        if ($year) {
            $query->whereYear('purchase.created_at', $year);
        }

        $data = $query->get();

        // Generate CSV content (basic example)
        $csvData[] = ['Nama Produk', 'Total Kuantitas', 'Total Penjualan', 'Profit per Produk', 'Total Profit'];
        foreach ($data as $item) {
            $csvData[] = [
                $item->product_name,
                $item->total_quantity,
                $item->total_sales,
                $item->profit_per_product,
                $item->profit_per_product * $item->total_quantity
            ];
        }

        $filename = 'rekomendasi-penjualan.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '",',
        ];

        // Use a standard Laravel way to return CSV response if available, otherwise basic
        // Assuming a basic response for now:
        $handle = fopen('php://temp', 'r+');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent, 200, $headers);

        // If using a dedicated CSV export library (like maatwebsite/excel with a dedicated Export class):
        // return Excel::download(new SalesRecommendationExport($data), 'rekomendasi-penjualan.csv');
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

