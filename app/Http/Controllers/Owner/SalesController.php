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

        return Inertia::render('Owner/Sales', [
            'sales' => $data,
            'months' => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            'years' => ['2023', '2024', '2025', '2026', '2027', '2028', '2029','2030','2031','2032','2033','2034','2035','2036','2037','2038','2039','2040']
        ]);
    }

    public function export()
    {
        $data = DB::table('purchase')
            ->select(
                'invoice_number',
                DB::raw('MIN(created_at) as date'),
                DB::raw('MIN(payment_method) as payment_method'),
                DB::raw('SUM(total_price) as total_amount'),
                DB::raw('COUNT(*) as total_items')
            )
            ->groupBy('invoice_number')
            ->orderBy('date', 'desc')
            ->get();

        $csvData = [];
        $csvData[] = ['No. Invoice', 'Tanggal', 'Metode Pembayaran', 'Total Item', 'Total Harga']; // Header

        foreach ($data as $invoice) {
            $csvData[] = [
                $invoice->invoice_number,
                $invoice->date,
                $invoice->payment_method,
                $invoice->total_items,
                $invoice->total_amount
            ];
        }

        $filename = 'sales_data_' . date('Y-m-d_H-i-s') . '.csv';

        $response = new StreamedResponse(function () use ($csvData) {
            $handle = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $filename . '"');

        return $response;
    }
}
