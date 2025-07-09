<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorPrescriptionTransaction;
use App\Models\Prescription; 
use App\Models\DoctorPrescriptionTransactionDetail;


class DoctorPrescriptionTransactionController extends Controller
{
    //
    public function index()
    {
        $transactions = DoctorPrescriptionTransaction::latest()->get();
        return view('resep-transactions.index', compact('transactions'));

    }
     public function create()
    {
        return view('resep-transactions.create');
    }

    public function store(Request $request)
    {
        
        // Validasi input
        $validated = $request->validate([
            // 'no_resep' => 'required|string|unique:resep_dokter,no_resep',
            // 'doctor_name' => 'required|string|max:255',
            // 'hospital_name' => 'required|string|max:255',
            // 'patient_name' => 'required|string|max:255',
            // 'transaction_date' => 'required|date',
            // 'total_price' => 'required|numeric|min:0',
            'no_resep' => 'required|string|unique:resep_dokter,no_resep',
            'doctor_name' => 'required|string|max:255',
            'hospital_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        // Hitung total harga
        $total_price = collect($validated['products'])->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });

        // Simpan ke transaksi resep dokter
        $transaction = DoctorPrescriptionTransaction::create([
            // 'doctor_name' => $validated['doctor_name'],
            // 'patient_name' => $validated['patient_name'],
            // 'transaction_date' => $validated['transaction_date'],
            // 'total_price' => $validated['total_price'],
            // 'hospital_name' => $validated['hospital_name'],
            'doctor_name' => $validated['doctor_name'],
            'patient_name' => $validated['patient_name'],
            'hospital_name' => $validated['hospital_name'],
            'transaction_date' => $validated['transaction_date'],
            'total_price' => $total_price,
            'notes' => $validated['notes'],
            'user_id' => auth()->id(),
        ]);

        // Simpan juga ke tabel prescriptions (admin)
        Prescription::create([
            // 'no_resep' => $validated['no_resep'],
            // 'tanggal_resep' => $validated['transaction_date'],
            // 'nama_dokter' => $validated['doctor_name'],
            // 'rumah_sakit' => $validated['hospital_name'],
            // 'nama_pasien' => $validated['patient_name'],
            'no_resep' => $validated['no_resep'],
            'tanggal_resep' => $validated['transaction_date'],
            'nama_dokter' => $validated['doctor_name'],
            'rumah_sakit' => $validated['hospital_name'],
            'nama_pasien' => $validated['patient_name'],
        ]);

        // Simpan detail obat
            foreach ($validated['products'] as $product) {
                DoctorPrescriptionTransactionDetail::create([
                    'doctor_prescription_transaction_id' => $transaction->id,
                    'product_name' => $product['name'], // ✅ ini benar
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }

            
    //     // proses simpan transaksi resep
    //     $validated = $request->validate([
    //     'doctor_name' => 'required|string|max:255',
    //     'patient_name' => 'required|string|max:255',
    //     'transaction_date' => 'required|date',
    //     'total_price' => 'required|numeric|min:0',
    // ]);

    // DoctorPrescriptionTransaction::create($validated);

    return redirect()->route('resep-transactions.index')->with('success', 'Transaksi resep berhasil disimpan.');
    }

    // public function show($id)
    // {
    //     $transaction = \App\Models\DoctorPrescriptionTransaction::findOrFail($id);
    // return view('resep-transactions.show', compact('transaction'));
    // }
    public function show($id)
    {
        $transaction = DoctorPrescriptionTransaction::with('details.product')->findOrFail($id);
        return view('resep-transactions.show', compact('transaction'));
    }



    public function edit($id)
    {
        $transaction = DoctorPrescriptionTransaction::findOrFail($id);
        return view('resep-transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'doctor_name' => 'required|string|max:255',
            'patient_name' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
        ]);

        $transaction = DoctorPrescriptionTransaction::findOrFail($id);
        $transaction->update($validated);

        return redirect()->route('resep-transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaction = DoctorPrescriptionTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('resep-transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }


public function storeResep(Request $request)
{
    // Validasi dan simpan transaksi resep
    // (Implementasi bergantung pada struktur data kamu)

    // Ubah status resep jadi 'selesai'
    Resep::find($request->resep_id)->update(['status' => 'selesai']);

    return redirect()->route('transactions.resep')->with('success', 'Transaksi resep berhasil disimpan.');
}

}
