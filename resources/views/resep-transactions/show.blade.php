<x-app-layout>
    <x-page-title>Detail Transaksi Resep Dokter</x-page-title>

    <div class="bg-white p-4 rounded shadow-sm">
        <h5 class="mb-4">Informasi Umum</h5>
        <table class="table table-bordered">
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $transaction->patient_name }}</td>
            </tr>
            <tr>
                <th>Nama Dokter</th>
                <td>{{ $transaction->doctor_name }}</td>
            </tr>
            <tr>
                <th>Tanggal Transaksi</th>
                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td>{{ $transaction->notes ?? '-' }}</td>
            </tr>
        </table>

        <h5 class="mt-5 mb-3">Daftar Obat yang Diresepkan</h5>
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($transaction->details as $index => $item)
                    @php
                        $subtotal = $item->quantity * $item->price;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <!-- <td>{{ $item->product->name ?? '-' }}</td> -->
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th>Rp{{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('resep-transactions.index') }}" class="btn btn-secondary mt-4">Kembali</a>
    </div>
</x-app-layout>
