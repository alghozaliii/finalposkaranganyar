<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SalesController extends Controller
{
    public function index(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    
    $query = DB::table('purchase')
        ->join('products', 'purchase.product_id', '=', 'products.id')
        ->select(
            'purchase.id',
            'products.name as product_name',
            'purchase.quantity',
            'purchase.total_price',
            'purchase.payment_method',
            'purchase.created_at'
        );

    if ($month) {
        $query->whereMonth('purchase.created_at', $month);
    }

    if ($year) {
        $query->whereYear('purchase.created_at', $year);
    }

    $data = $query->orderBy('purchase.created_at', 'desc')->get();

    return Inertia::render('Owner/Sales', [
        'sales' => $data,
        'months' => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'], // data bulan
        'years' => ['2023', '2024', '2025', '2026', '2027', '2028', '2029','2030','2031','2032','2033','2034','2035','2036','2037','2038','2039','2040',] // data tahun
    ]);
}

    // Fungsi export CSV
    public function export()
    {
        $data = DB::table('purchase')
            ->join('products', 'purchase.product_id', '=', 'products.id')
            ->select(
                'purchase.id',
                'products.name as product_name',
                'purchase.quantity',
                'purchase.total_price',
                'purchase.payment_method',
                'purchase.created_at'
            )
            ->orderBy('purchase.created_at', 'desc')
            ->get();

        $csvData = [];
        $csvData[] = ['ID', 'Nama Produk', 'Jumlah', 'Total Harga', 'Metode Pembayaran', 'Tanggal']; // Header

        foreach ($data as $row) {
            $csvData[] = [
                $row->id,
                $row->product_name,
                $row->quantity,
                $row->total_price,
                $row->payment_method,
                $row->created_at
            ];
        }

        $filename = 'sales_data_' . date('Y-m-d_H-i-s') . '.csv';

        // Create a response for the CSV file
        $response = new StreamedResponse(function () use ($csvData) {
            $handle = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        });

        // Set the headers for the CSV download
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');

        return $response;
    }
   

}
