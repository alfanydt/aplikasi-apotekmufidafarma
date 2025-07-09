<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResepTransactionController extends Controller
{
    //
    public function index()
{
    $reseps = Resep::with(['details', 'patient'])->where('status', 'belum')->get();
    return view('resep-transaction.index', compact('reseps'));
}

public function create(Resep $resep)
{
    return view('resep-transaction.create', compact('resep'));
}

public function store(Request $request)
{
    // logika simpan transaksi resep
}

}
