<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Profit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // Get current month data
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth();

        $ownerId = auth()->id(); // Get the authenticated owner's ID

        // Get employees data
        $employees = User::where('owner_id', $ownerId)
            ->where('role_id', 3)
            ->select('id', 'name', 'employees_role', 'created_at') // Changed username to name
            ->get()
            ->map(function($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name, // Using name instead of username
                    'employees_role' => $employee->employees_role,
                    'created_at' => $employee->created_at->format('d/m/Y H:i'),
                ];
            });

        // Calculate total revenue for current month
        $totalRevenue = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $currentMonth)
            ->whereYear('purchase.created_at', $currentYear)
            ->sum('purchase.total_price');

        // Calculate last month's revenue for growth
        $lastMonthRevenue = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $lastMonth->month)
            ->whereYear('purchase.created_at', $lastMonth->year)
            ->sum('purchase.total_price');

        // Calculate revenue growth
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Calculate total sales (transactions) for current month
        $totalSales = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $currentMonth)
            ->whereYear('purchase.created_at', $currentYear)
            ->count();

        // Calculate last month's sales for growth
        $lastMonthSales = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $lastMonth->month)
            ->whereYear('purchase.created_at', $lastMonth->year)
            ->count();

        // Calculate sales growth
        $salesGrowth = $lastMonthSales > 0 
            ? (($totalSales - $lastMonthSales) / $lastMonthSales) * 100 
            : 0;

        // Get monthly revenue data for chart
        $monthlyRevenue = collect(range(1, 12))->map(function($month) use ($currentYear, $ownerId) {
            $revenue = DB::table('purchase')
                ->join('products', 'purchase.product_id', '=', 'products.id')
                ->where('products.user_id', $ownerId)
                ->whereMonth('purchase.created_at', $month)
                ->whereYear('purchase.created_at', $currentYear)
                ->sum('purchase.total_price');
            
            return [
                'month' => Carbon::create()->month($month)->format('F'),
                'revenue' => $revenue
            ];
        });

        // Get recent transactions for first table
        $recentTransactions = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->orderBy('purchase.created_at', 'desc')
            ->limit(10) // Get latest 10 transactions
            ->get();

        // Calculate total monthly transactions for percentage calculation
        $totalMonthlyTransactions = DB::table('purchase')
             ->join('products', 'purchase.product_id', '=', 'products.id')
             ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $currentMonth)
            ->whereYear('purchase.created_at', $currentYear)
            ->count();

        // Get top selling products for current month
        $topSellingProducts = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->where('products.user_id', $ownerId)
            ->select(
                'products.name as product_name', // Select product name from products table
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(purchase.quantity) as total_quantity'),
                DB::raw('SUM(purchase.total_price) as total_sales')
            )
            ->whereMonth('purchase.created_at', $currentMonth)
            ->whereYear('purchase.created_at', $currentYear)
            ->groupBy('products.name') // Group by product name from products table
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get()
            ->map(function($product) use ($totalMonthlyTransactions) {
                $salesPercentage = $totalMonthlyTransactions > 0 ? round(($product->total_transactions / $totalMonthlyTransactions) * 100, 1) : 0;
                return [
                    'name' => $product->product_name,
                    'sales_percentage' => $salesPercentage, // Use a different key name
                    'total_quantity' => $product->total_quantity,
                    'total_sales' => $product->total_sales
                ];
            });

        // Calculate total unique customers (based on unique invoice numbers)
        // Note: This assumes each unique invoice number corresponds to a unique customer in this context
        $totalCustomers = DB::table('purchase')
             ->join('products', 'purchase.product_id', '=', 'products.id')
             ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $currentMonth)
            ->whereYear('purchase.created_at', $currentYear)
            ->distinct('invoice_number')
            ->count('invoice_number');

        $lastMonthCustomers = DB::table('purchase')
             ->join('products', 'purchase.product_id', '=', 'products.id')
             ->where('products.user_id', $ownerId)
            ->whereMonth('purchase.created_at', $lastMonth->month)
            ->whereYear('purchase.created_at', $lastMonth->year)
            ->distinct('invoice_number')
            ->count('invoice_number');

        // Calculate customer growth
        $customerGrowth = $lastMonthCustomers > 0 
            ? (($totalCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100 
            : 0;

        return Inertia::render('OwnerDashboard', [
            'employees' => $employees,
            'totalRevenue' => $totalRevenue,
            'totalSales' => $totalSales,
            'totalCustomers' => $totalCustomers,
            'revenueGrowth' => round($revenueGrowth, 1),
            'salesGrowth' => round($salesGrowth, 1),
            'customerGrowth' => round($customerGrowth, 1),
            'monthlyRevenueData' => $monthlyRevenue, // Renamed to avoid conflict
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