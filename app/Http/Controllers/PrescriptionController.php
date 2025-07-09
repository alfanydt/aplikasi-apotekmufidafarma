<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the prescriptions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $prescriptions = Prescription::orderBy('created_at', 'desc')->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new prescription.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('prescriptions.create');
    }

    /**
     * Store a newly created prescription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       $request->validate([
        'no_resep' => 'required|string|unique:resep_dokter,no_resep',
        'tanggal_resep' => 'required|date',
        'nama_dokter' => 'required|string',
        'rumah_sakit' => 'nullable|string',
        'nama_pasien' => 'required|string',
    ]);
    // Simpan ke tabel prescriptions
    \App\Models\Prescription::create([
        'no_resep' => $request->no_resep,
        'tanggal_resep' => $request->tanggal_resep,
        'nama_dokter' => $request->nama_dokter,
        'rumah_sakit' => $request->rumah_sakit ?? '-',
        'nama_pasien' => $request->nama_pasien,
    ]);

    return redirect()->route('prescriptions.index')->with('success', 'Resep dokter berhasil disimpan.');
}

    /**
     * Display the specified prescription.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $prescription = \App\Models\Prescription::findOrFail($id);
        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified prescription.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $prescription = \App\Models\Prescription::findOrFail($id);
        return view('prescriptions.edit', compact('prescription'));
    }

    /**
     * Update the specified prescription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_resep' => 'required|string|unique:resep_dokter,no_resep,' . $id,
            'tanggal_resep' => 'required|date',
            'nama_dokter' => 'required|string',
            'rumah_sakit' => 'required|string',
            'nama_pasien' => 'required|string',
        ]);

        $prescription = \App\Models\Prescription::findOrFail($id);
        $prescription->update($request->all());

        return redirect()->route('prescriptions.index')->with('success', 'Resep dokter updated successfully.');
    }

    /**
     * Remove the specified prescription from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $prescription = \App\Models\Prescription::findOrFail($id);
        $prescription->delete();

        return redirect()->route('prescriptions.index')->with('success', 'Resep dokter deleted successfully.');
    }
}
