<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Laporan Penjualan Obat</x-page-title>

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Penjualan Obat</li>
        </ol>
    </nav>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="alert alert-info mb-5" role="alert">
            <i class="ti ti-package fs-5 me-2"></i> Lihat performa penjualan untuk setiap produk dalam rentang tanggal tertentu.
        </div>
        
        <form action="{{ route('sales-by-product.filter') }}" method="GET" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-lg-4 col-xl-3 mb-4 mb-lg-0">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="text" name="start_date" class="form-control datepicker @error('start_date') is-invalid @enderror" value="{{ old('start_date', request('start_date')) }}" autocomplete="off">
                    @error('start_date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-4 col-xl-3">
                    <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                    <input type="text" name="end_date" class="form-control datepicker @error('end_date') is-invalid @enderror" value="{{ old('end_date', request('end_date')) }}" autocomplete="off">
                    @error('end_date')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
    
            <div class="pt-4 pb-2 mt-5 border-top">
                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                    <button type="submit" class="btn btn-info py-2 px-4">
                        Tampilkan Laporan <i class="ti ti-chevron-right align-middle ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

@if (request(['start_date', 'end_date']) && isset($salesData))
        <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
            <div class="d-flex flex-column flex-lg-row mb-4">
                <div class="flex-grow-1 d-flex align-items-center">
                    <h6 class="mb-0">
                        <i class="ti ti-chart-bar fs-5 align-text-top me-1"></i> 
                        Laporan Penjualan Per Obat - {{ date('d F Y', strtotime(request('start_date'))) }} sampai {{ date('d F Y', strtotime(request('end_date'))) }}
                    </h6>
                </div>
                <div class="d-grid gap-3 d-sm-flex mt-3 mt-lg-0">
<a href="{{ route('sales-by-product.print', [request('start_date'), request('end_date')]) }}" target="_blank" class="btn btn-warning py-2 px-3">
                        <i class="ti ti-printer me-2"></i> Cetak
                    </a>
                </div>
            </div>

            <hr class="mb-4">

            {{-- Summary --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h5 class="text-primary">Total Produk Terjual</h5>
                            <h3 class="text-primary">{{ $salesData->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="text-success">Total Kuantitas</h5>
                            <h3 class="text-success">{{ number_format($salesData->sum('total_qty')) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h5 class="text-info">Total Pendapatan</h5>
                            <h3 class="text-info">Rp {{ number_format($salesData->sum('total_revenue'), 0, '', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Peringkat</th>
                            <th>Nama Produk</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-center">Jumlah Terjual</th>
                            <th class="text-end">Total Pendapatan</th>
                            <th class="text-center">Transaksi</th>
                            <th class="text-center">Performa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $rank = 1;
                            $totalRevenue = $salesData->sum('total_revenue');
                        @endphp
                        @forelse ($salesData as $data)
                            <tr>
                                <td class="text-center">
                                    @if($rank <= 3)
                                        <span class="badge bg-{{ $rank == 1 ? 'warning' : ($rank == 2 ? 'secondary' : 'success') }}">
                                            {{ $rank }}
                                        </span>
                                    @else
                                        {{ $rank }}
                                    @endif
                                </td>
                                <td>{{ $data['product_name'] }}</td>
                                <td class="text-end">Rp {{ number_format($data['unit_price'], 0, '', '.') }}</td>
                                <td class="text-center">{{ number_format($data['total_qty']) }}</td>
                                <td class="text-end">Rp {{ number_format($data['total_revenue'], 0, '', '.') }}</td>
                                <td class="text-center">{{ $data['transactions_count'] }}</td>
                                <td class="text-center">
                                    @php
                                        $percentage = $totalRevenue > 0 ? ($data['total_revenue'] / $totalRevenue) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-{{ $percentage >= 20 ? 'success' : ($percentage >= 10 ? 'warning' : 'info') }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%"
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php $rank++; @endphp
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="ti ti-info-circle fs-5 me-2"></i>
                                        <div>Data tidak tersedia.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-app-layout>
