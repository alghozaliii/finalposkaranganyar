<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Profit;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil total profit dari tabel profit
        $totalProfit = Profit::sum('total_profit');

        // 2. (Opsional) Data lain untuk dashboard
        $totalSales = Profit::sum('total_quantity');
        $topProducts = Profit::orderByDesc('total_quantity')->take(5)->get();
        $transactionHistory = []; // Isi sesuai kebutuhan Anda

        // 3. Kirim ke view
        return Inertia::render('OwnerDashboard', [
            'totalRevenue' => $totalProfit,
            'totalSales' => $totalSales,
            'topProducts' => $topProducts,
            'transactionHistory' => $transactionHistory,
            // Tambahkan props lain sesuai kebutuhan
        ]);
    }
}