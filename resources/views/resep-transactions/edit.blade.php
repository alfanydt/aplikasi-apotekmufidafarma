<x-app-layout>
    <x-page-title>Edit Transaksi Resep Dokter</x-page-title>

    <form action="{{ route('resep-transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm rounded-2 p-4">
            <div class="mb-3">
                <label for="doctor_name" class="form-label">Nama Dokter</label>
                <input type="text" name="doctor_name" id="doctor_name" class="form-control" value="{{ $transaction->doctor_name }}" required>
            </div>
            <div class="mb-3">
                <label for="patient_name" class="form-label">Nama Pasien</label>
                <input type="text" name="patient_name" id="patient_name" class="form-control" value="{{ $transaction->patient_name }}" required>
            </div>
            <div class="mb-3">
                <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ $transaction->transaction_date }}" required>
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Harga</label>
                <input type="number" name="total_price" id="total_price" class="form-control" value="{{ $transaction->total_price }}" required>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Perbarui</button>
                <a href="{{ route('resep-transactions.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</x-app-layout>
