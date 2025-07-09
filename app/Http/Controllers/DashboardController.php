<?php

namespace App\Http\Controllers;

use App\Models\Category;
// use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();

        if ($user->role === 'kasir') {
            return redirect()->route('transactions.index');
        }
        // menampilkan jumlah data category
        $totalCategory = Category::count();
        // menampilkan jumlah data product
        $totalProduct = Product::count();
        // menampilkan jumlah data customer
        // $totalCustomer = Customer::count();
        // menampilkan jumlah data transaction
        $totalTransaction = Transaction::count();

        // menampilkan data 5 product terlaris
        $transactions = Transaction::select('product_id', DB::raw('sum(qty) as transactions_sum_qty'))->with('product:id,name,price,image')
            ->groupBy('product_id')
            ->orderBy('transactions_sum_qty', 'desc')
            ->take(5)
            ->get();

        // tampilkan data ke view
        return view('dashboard.index', compact('totalCategory', 'totalProduct', 'totalTransaction', 'transactions'));
    }
}
