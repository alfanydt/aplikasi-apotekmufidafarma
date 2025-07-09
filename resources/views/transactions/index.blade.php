<x-app-layout>
    <x-page-title>Transaksi</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="row">
            <div class="d-grid d-lg-block col-lg-5 col-xl-6 mb-4 mb-lg-0">
                @if(auth()->user()->role === 'kasir')
                    <a href="{{ route('transactions.create') }}" class="btn btn-success py-2 px-3">
                        <i class="ti ti-plus me-2"></i> Tambah Transaksi
                    </a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary py-2 px-3">
                        <i class="ti ti-plus me-2"></i> Add Transaction
                    </a>
                @endif
            </div>
            <div class="col-lg-7 col-xl-6">
                <form action="{{ route('transactions.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control py-2" value="{{ request('search') }}" placeholder="Cari transaksi ..." autocomplete="off">
                        <button class="btn btn-primary py-2" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2 shadow-sm pt-4 px-4 pb-3 mb-5">
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 30px;">No.</th>
                        <th class="text-center" style="width: 120px;">Tanggal</th>
                        <th class="text-center">Obat</th>
                        <th class="text-center" style="width: 100px;">Harga</th>
                        <th class="text-center" style="width: 60px;">Qty</th>
                        <th class="text-center" style="width: 100px;">Subtotal</th>
                        <th class="text-center" style="width: 100px;">Total Bayar</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="text-center" style="width: 120px;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $i = $transactions->firstItem(); 
                        $grandTotal = 0;
                    @endphp
                    @forelse ($transactions as $transaction)
                        @php $grandTotal += $transaction->total; @endphp
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                            <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                            <td class="text-end">{{ 'Rp ' . number_format($transaction->product->harga_satuan ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $transaction->qty }}</td>
                            <td class="text-end">{{ 'Rp ' . number_format($transaction->total, 0, ',', '.') }}</td>
                            <td class="text-end">{{ 'Rp ' . number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                            @if(auth()->user()->role === 'admin')
                                <td class="text-center">
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm m-1" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $transaction->id }}" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>

                        {{-- Modal Delete --}}
                        <div class="modal fade" id="modalDelete{{ $transaction->id }}" tabindex="-1" aria-labelledby="modalDeleteLabel{{ $transaction->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="ti ti-trash me-2"></i> Delete Transaction
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this transaction?</p>
                                        <div class="alert alert-info">
                                            <strong>Product:</strong> {{ $transaction->product->name ?? 'N/A' }}<br>
                                            <strong>Quantity:</strong> {{ $transaction->qty }}<br>
                                            <strong>Total:</strong> Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, delete it!</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}" class="text-center">No data available.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($transactions->count() > 0)
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Grand Total</th>
                        <th class="text-end">{{ 'Rp ' . number_format($grandTotal, 0, ',', '.') }}</th>
                        <th></th>
                        @if(auth()->user()->role === 'admin')
                            <th></th>
                        @endif
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-links">{{ $transactions->links() }}</div>
    </div>
</x-app-layout>