<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Profit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Get current month data
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth();

        // Calculate total revenue for current month
        $totalRevenue = DB::table('purchase')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        // Calculate last month's revenue for growth
        $lastMonthRevenue = DB::table('purchase')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_price');

        // Calculate revenue growth
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Calculate total sales (transactions) for current month
        $totalSales = DB::table('purchase')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Calculate last month's sales for growth
        $lastMonthSales = DB::table('purchase')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        // Calculate sales growth
        $salesGrowth = $lastMonthSales > 0 
            ? (($totalSales - $lastMonthSales) / $lastMonthSales) * 100 
            : 0;

        // Get monthly revenue data for chart
        $monthlyRevenue = collect(range(1, 12))->map(function($month) use ($currentYear) {
            $revenue = DB::table('purchase')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $currentYear)
                ->sum('total_price');
            
            return [
                'month' => Carbon::create()->month($month)->format('F'),
                'revenue' => $revenue
            ];
        });

        // Get recent transactions for first table
        $recentTransactions = DB::table('purchase')
            ->select(
                'invoice_number',
                'created_at',
                'payment_method',
                DB::raw('COUNT(*) as total_items'),
                DB::raw('SUM(total_price) as total_amount')
            )
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('invoice_number', 'created_at', 'payment_method')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(function($transaction) {
                return [
                    'id' => $transaction->invoice_number,
                    'date' => Carbon::parse($transaction->created_at)->format('d/m/Y H:i'),
                    'cashier' => 'Kasir',
                    'totalItem' => $transaction->total_items,
                    'totalPrice' => $transaction->total_amount,
                    'paymentMethod' => $transaction->payment_method,
                    'status' => 'Success'
                ];
            });

        // Get top products for second table with percentage
        $totalMonthlyTransactions = DB::table('purchase')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $topSellingProducts = DB::table('purchase')
            ->select(
                'product_name',
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total_price) as total_sales')
            )
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get()
            ->map(function($product) use ($totalMonthlyTransactions) {
                return [
                    'name' => $product->product_name,
                    'sales' => round(($product->total_transactions / $totalMonthlyTransactions) * 100, 1),
                    'total_quantity' => $product->total_quantity,
                    'total_sales' => $product->total_sales
                ];
            });

        // Calculate total unique customers (based on unique invoice numbers)
        $totalCustomers = DB::table('purchase')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->distinct('invoice_number')
            ->count('invoice_number');

        $lastMonthCustomers = DB::table('purchase')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->distinct('invoice_number')
            ->count('invoice_number');

        // Calculate customer growth
        $customerGrowth = $lastMonthCustomers > 0 
            ? (($totalCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100 
            : 0;

        return Inertia::render('OwnerDashboard', [
            'totalRevenue' => $totalRevenue,
            'totalSales' => $totalSales,
            'totalCustomers' => $totalCustomers,
            'revenueGrowth' => round($revenueGrowth, 1),
            'salesGrowth' => round($salesGrowth, 1),
            'customerGrowth' => round($customerGrowth, 1),
            'monthlyRevenue' => $monthlyRevenue,
            'topProducts' => $topSellingProducts,
            'transactionHistory' => $recentTransactions,
            'chartLabels' => $monthlyRevenue->pluck('month'),
            'currentMonth' => Carbon::now()->format('F'),
            'startDate' => Carbon::now()->startOfMonth()->format('d M Y'),
            'endDate' => Carbon::now()->endOfMonth()->format('d M Y'),
            'activeTab' => 'Month'
        ]);
    }
}