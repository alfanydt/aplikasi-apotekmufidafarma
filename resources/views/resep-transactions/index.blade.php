<x-app-layout>
    <x-page-title>Transaksi Resep Dokter</x-page-title>

    <div class="card shadow-sm rounded-2 p-4">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0">Daftar Transaksi Resep</h5>
            <a href="{{ route('resep-transactions.create') }}" class="btn btn-primary">+ Tambah Transaksi</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $i => $transaction)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $transaction->doctor_name }}</td>
                            <td>{{ $transaction->patient_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                            
                            <td>
                                <a href="{{ route('resep-transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">Detail</a>
                                
                                <a href="{{ route('resep-transactions.edit', $transaction->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('resep-transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi resep.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
