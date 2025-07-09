<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // tampilkan view
        return view('report.index');
    }

    /**
     * filter
     */

    public function filterTransactions(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        $transactions = Transaction::with('product:id,name,harga_satuan')
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->oldest('date')
            ->get();
        
        return view('report.index', compact('transactions'));
    }

    public function printTransactions($startDate, $endDate)
    {
        $transactions = Transaction::with('product:id,name,harga_satuan')
            ->whereBetween('date', [$startDate, $endDate])
            ->oldest('date')
            ->get();

        $pdf = Pdf::loadView('report.print', compact('transactions', 'startDate', 'endDate'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Transaksi.pdf');
    }


    // =================================================================
    // LAPORAN LABA RUGI
    // =================================================================

    public function showProfitLoss()
    {
        return view('report.labarugi');
    }

    public function filterProfitLoss(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);

        $transactions = Transaction::with('product:id,name,price')
                            ->whereBetween('date', [$request->start_date, $request->end_date])
                            ->get();

        $totalRevenue = $transactions->sum('total');

        // Hitung total biaya sebagai jumlah harga per box untuk setiap produk yang terjual
        $productCosts = Transaction::with('product:id,name,price')
            ->select('product_id', DB::raw('COUNT(DISTINCT product_id) as product_count'))
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->groupBy('product_id')
            ->get();

        $totalCost = $productCosts->sum(function ($item) {
            return $item->product->price;
        });

        $grossProfit = $totalRevenue - $totalCost;

        // Logika untuk detail per produk
        $productDetails = Transaction::with('product:id,name,price')
            ->select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(total) as total_revenue'))
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) {
                $cost = $item->product->price; // harga per box
                $revenue = $item->total_revenue;
                $profit = $revenue - $cost;
                return (object) [
                    'product_name' => $item->product->name,
                    'total_qty' => $item->total_qty,
                    'total_revenue' => $revenue,
                    'total_cost' => $cost,
                    'profit' => $profit,
                ];
            });

        return view('report.labarugi', compact('totalRevenue', 'totalCost', 'grossProfit', 'productDetails'));
    }

    public function printProfitLoss($startDate, $endDate)
    {
        // Anda perlu membuat view baru untuk print PDF, misalnya `report.print_labarugi.blade.php`
        // Logikanya sama dengan method filter
        $transactions = Transaction::with('product:id,price')->whereBetween('date', [$startDate, $endDate])->get();
        $totalRevenue = $transactions->sum('total');
        $totalCost = $transactions->sum(fn($t) => $t->qty * $t->product->price);
        $grossProfit = $totalRevenue - $totalCost;
        
        $productDetails = Transaction::with('product:id,name,price')
            ->select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(total) as total_revenue'))
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) {
                $cost = $item->product->price;
                $revenue = $item->total_revenue;
                $profit = $revenue - $cost;
                return (object) [
                    'product_name' => $item->product->name,
                    'total_qty' => $item->total_qty,
                    'total_revenue' => $revenue,
                    'total_cost' => $cost,
                    'profit' => $profit,
                ];
            });

        $pdf = Pdf::loadView('report.print_labarugi', compact('totalRevenue', 'totalCost', 'grossProfit', 'startDate', 'endDate', 'productDetails'));
        return $pdf->stream('Laporan_Laba_Rugi.pdf');
    }


    // =================================================================
    // LAPORAN PENJUALAN PER OBAT
    // =================================================================

    public function showSalesByProduct()
    {
        return view('report.penjualan-per-obat');
    }

    public function filterSalesByProduct(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date'
        ]);
        
        $salesData = Transaction::join('products', 'transactions.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'products.harga_satuan as unit_price',
                DB::raw('SUM(transactions.qty) as total_qty'),
                DB::raw('SUM(transactions.total) as total_revenue'),
                DB::raw('COUNT(transactions.id) as transactions_count')
            )
            ->whereBetween('transactions.date', [$request->start_date, $request->end_date])
            ->groupBy('products.id', 'products.name', 'products.harga_satuan')
            ->orderByDesc(DB::raw('SUM(transactions.total)'))
            ->get();

        return view('report.penjualan-per-obat', compact('salesData'));
    }

    public function printSalesByProduct($startDate, $endDate)
    {
        // Anda perlu membuat view baru untuk print PDF, misalnya `report.print_penjualan_per_obat.blade.php`
        $salesData = Transaction::join('products', 'transactions.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'products.harga_satuan as unit_price',
                DB::raw('SUM(transactions.qty) as total_qty'),
                DB::raw('SUM(transactions.total) as total_revenue'),
                DB::raw('COUNT(transactions.id) as transactions_count')
            )
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.harga_satuan')
            ->orderByDesc(DB::raw('SUM(transactions.total)'))
            ->get();

        $pdf = Pdf::loadView('report.print_penjualan_per_obat', compact('salesData', 'startDate', 'endDate'));
        return $pdf->stream('Laporan_Penjualan_Per_Obat.pdf');
    }

//     public function filter(Request $request): View
//     {
//         // validasi form
//         $request->validate([
//             'start_date' => 'required',
//             'end_date'   => 'required|date|after_or_equal:start_date'
//         ]);

//         // data filter
//         $startDate = $request->start_date;
//         $endDate   = $request->end_date;

//         // menampilkan data berdasarkan filter - perbaiki select kolom
//         $transactions = Transaction::with('product:id,name,harga_satuan')
//             ->whereBetween('date', [$startDate, $endDate])
//             ->oldest()
//             ->get();

//         // tampilkan data ke view
//         return view('report.index', compact('transactions'));
//     }

//     /**
//      * print (PDF)
//      */
//     public function print($startDate, $endDate)
//     {   
//         // menampilkan data berdasarkan filter - perbaiki select kolom
//         $transactions = Transaction::with('product:id,name,harga_satuan')
//             ->whereBetween('date', [$startDate, $endDate])
//             ->oldest()
//             ->get();

//         // load view PDF
//         $pdf = Pdf::loadview('report.print', compact('transactions'))->setPaper('a4', 'landscape');
//         // tampilkan ke browser
//         return $pdf->stream('Transactions.pdf');
//     }
}