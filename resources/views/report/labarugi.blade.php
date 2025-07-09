<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Laporan Laba Rugi</x-page-title>

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Laba Rugi</li>
        </ol>
    </nav>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="alert alert-success mb-5" role="alert">
            <i class="ti ti-trending-up fs-5 me-2"></i> Analisis laba rugi bisnis Anda dalam rentang tanggal tertentu.
        </div>
        
<form action="{{ route('profit-loss.filter') }}" method="GET" class="needs-validation" novalidate>
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
                    <button type="submit" class="btn btn-success py-2 px-4">
                        Tampilkan Laporan <i class="ti ti-chevron-right align-middle ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if (request(['start_date', 'end_date']) && isset($totalRevenue))
        <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
            <div class="d-flex flex-column flex-lg-row mb-4">
                <div class="flex-grow-1 d-flex align-items-center">
                    <h6 class="mb-0">
                        <i class="ti ti-chart-line fs-5 align-text-top me-1"></i> 
                        Laporan Laba Rugi - {{ date('d F Y', strtotime(request('start_date'))) }} sampai {{ date('d F Y', strtotime(request('end_date'))) }}
                    </h6>
                </div>
                <div class="d-grid gap-3 d-sm-flex mt-3 mt-lg-0">
                    <a href="{{ route('profit-loss.print', [request('start_date'), request('end_date')]) }}" target="_blank" class="btn btn-warning py-2 px-3">
                        <i class="ti ti-printer me-2"></i> Cetak
                    </a>
                </div>
            </div>

            <hr class="mb-4">

            {{-- Summary Cards --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="text-success">Total Pendapatan</h5>
                            <h3 class="text-success">Rp {{ number_format($totalRevenue, 0, '', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h5 class="text-danger">Total Biaya</h5>
                            <h3 class="text-danger">Rp {{ number_format($totalCost, 0, '', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-{{ $grossProfit >= 0 ? 'primary' : 'warning' }}">
                        <div class="card-body text-center">
                            <h5 class="text-{{ $grossProfit >= 0 ? 'primary' : 'warning' }}">Laba Kotor</h5>
                            <h3 class="text-{{ $grossProfit >= 0 ? 'primary' : 'warning' }}">
                                Rp {{ number_format($grossProfit, 0, '', '.') }}
                            </h3>
                            <small class="text-muted">
                                Margin: {{ $totalRevenue > 0 ? number_format(($grossProfit / $totalRevenue) * 100, 1) : 0 }}%
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail per Product --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah Terjual</th>
                            <th class="text-end">Pendapatan</th>
                            <th class="text-end">Biaya</th>
                            <th class="text-end">Laba</th>
                            <th class="text-center">Margin %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($productDetails as $detail)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $detail->product_name }}</td>
                                <td class="text-center">{{ number_format($detail->total_qty) }}</td>
                                <td class="text-end">Rp {{ number_format($detail->total_revenue, 0, '', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($detail->total_cost, 0, '', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($detail->profit, 0, '', '.') }}</td>
                                <td class="text-center">
                                    @php
                                        $margin = $detail->total_revenue > 0 ? ($detail->profit / $detail->total_revenue) * 100 : 0;
                                    @endphp
                                    {{ number_format($margin, 1) }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-app-layout>
