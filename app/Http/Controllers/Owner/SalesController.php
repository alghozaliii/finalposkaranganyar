<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        
        // Base query
        $query = DB::table('purchase')
            ->select(
                'invoice_number',
                DB::raw('MIN(created_at) as date'),
                DB::raw('MIN(payment_method) as payment_method'),
                DB::raw('SUM(total_price) as total_amount'),
                DB::raw('COUNT(*) as total_items')
            )
            ->groupBy('invoice_number');

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $data = $query->orderBy('date', 'desc')->get();

        // Get items for each invoice
        foreach ($data as $invoice) {
            $items = DB::table('purchase')
                ->where('invoice_number', $invoice->invoice_number)
                ->select('product_name', 'quantity', 'total_price')
                ->get();
            $invoice->items = $items;
        }

        // Get top products
        $topProducts = DB::table('purchase')
            ->select(
                'product_name as name',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('COUNT(*) as sales'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Get monthly sales for chart
        $monthlySales = DB::table('purchase')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereYear('created_at', $year ?: date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $chartLabels = collect(range(1, 12))->map(function($month) {
            return date('F', mktime(0, 0, 0, $month, 1));
        });

        return Inertia::render('Owner/Sales', [
            'sales' => $data,
            'topProducts' => $topProducts,
            'chartLabels' => $chartLabels,
            'chartData' => $monthlySales,
            'months' => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            'years' => ['2023', '2024', '2025', '2026', '2027', '2028', '2029','2030']
        ]);
    }

    public function exportSales(Request $request)
    {
        $query = DB::table('purchase')
            ->select(
                'invoice_number',
                DB::raw('MIN(created_at) as date'),
                DB::raw('MIN(payment_method) as payment_method'),
                DB::raw('SUM(total_price) as total_amount'),
                DB::raw('COUNT(*) as total_items')
            )
            ->groupBy('invoice_number');

        if ($request->month) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }

        $data = $query->orderBy('date', 'desc')->get();

        // Get items for each invoice
        foreach ($data as $invoice) {
            $items = DB::table('purchase')
                ->where('invoice_number', $invoice->invoice_number)
                ->select('product_name', 'quantity', 'total_price')
                ->get();
            $invoice->items = $items;
        }

        return Excel::download(new SalesExport($data), 'laporan-penjualan.xlsx');
    }
}
