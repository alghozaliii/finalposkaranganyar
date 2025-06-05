<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        
        $ownerId = auth()->id();

        // Query untuk mendapatkan daftar invoice penjualan milik owner ini
        $query = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->select(
                'purchase.invoice_number',
                DB::raw('MIN(purchase.created_at) as date'),
                DB::raw('MIN(purchase.payment_method) as payment_method'),
                DB::raw('SUM(purchase.total_price) as total_amount'),
                DB::raw('COUNT(purchase.id) as total_items')
            )
            ->groupBy('purchase.invoice_number');

        if ($month) {
            $query->whereMonth('purchase.created_at', $month);
        }

        if ($year) {
            $query->whereYear('purchase.created_at', $year);
        }

        $data = $query->orderBy('date', 'desc')->get();

        // Ambil detail item untuk setiap invoice, pastikan hanya item milik owner
        foreach ($data as $invoice) {
            $items = DB::table('purchase')
                ->join('products', 'purchase.product_id', '=', 'products.id')
                ->where('purchase.invoice_number', $invoice->invoice_number)
                ->where('products.user_id', $ownerId)
                ->select('products.name as product_name', 'purchase.quantity', 'purchase.total_price')
                ->get();
            $invoice->items = $items;
        }

        // Ambil top products untuk owner ini
        $topProducts = DB::table('purchase')
             ->join('products', 'purchase.product_id', '=', 'products.id')
             ->where('products.user_id', $ownerId)
            ->select(
                'products.name as name',
                DB::raw('SUM(purchase.quantity) as total_quantity'),
                DB::raw('COUNT(purchase.id) as sales'),
                DB::raw('SUM(purchase.total_price) as total_sales')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Ambil data penjualan bulanan untuk chart owner ini
        $monthlySales = DB::table('purchase')
             ->join('products', 'purchase.product_id', '=', 'products.id')
             ->where('products.user_id', $ownerId)
            ->select(
                DB::raw('EXTRACT(MONTH FROM purchase.created_at) as month'),
                DB::raw('SUM(purchase.total_price) as total_revenue')
            )
            ->whereYear('purchase.created_at', $year ?: date('Y'))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM purchase.created_at)'))
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
        $ownerId = auth()->id();

        // Query untuk data export, filter berdasarkan owner
        $query = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->select(
                'purchase.invoice_number',
                DB::raw('MIN(purchase.created_at) as date'),
                DB::raw('MIN(purchase.payment_method) as payment_method'),
                DB::raw('SUM(purchase.total_price) as total_amount'),
                DB::raw('COUNT(purchase.id) as total_items')
            )
            ->groupBy('purchase.invoice_number');

        if ($request->month) {
            $query->whereMonth('purchase.created_at', $request->month);
        }
        if ($request->year) {
            $query->whereYear('purchase.created_at', $request->year);
        }

        $data = $query->orderBy('date', 'desc')->get();

        // Ambil detail item untuk setiap invoice di export, pastikan hanya item milik owner
        foreach ($data as $invoice) {
            $items = DB::table('purchase')
                ->join('products', 'purchase.product_id', '=', 'products.id')
                ->where('purchase.invoice_number', $invoice->invoice_number)
                ->where('products.user_id', $ownerId)
                ->select('products.name as product_name', 'purchase.quantity', 'purchase.total_price')
                ->get();
            $invoice->items = $items;
        }

        return Excel::download(new SalesExport($data), 'laporan-penjualan.xlsx');
    }
}
