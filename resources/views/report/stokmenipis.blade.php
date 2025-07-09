<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Low Stock Alert Report</x-page-title>

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('report.index') }}">Reports</a></li>
            <li class="breadcrumb-item active">Low Stock Alert</li>
        </ol>
    </nav>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="alert alert-warning mb-5" role="alert">
            <i class="ti ti-alert-triangle fs-5 me-2"></i> Monitor products with low or empty stock levels.
        </div>
        
        <form action="{{ route('report.low-stock') }}" method="GET" class="needs-validation" novalidate>
            <div class="row">
                <div class="col-lg-4 col-xl-3 mb-4 mb-lg-0">
                    <label class="form-label">Minimum Stock Threshold</label>
                    <input type="number" name="min_stock" class="form-control" value="{{ $minStock }}" min="1" max="100">
                    <small class="text-muted">Products with stock equal or below this number will be shown</small>
                </div>
            </div>
    
            <div class="pt-4 pb-2 mt-5 border-top">
                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                    <button type="submit" class="btn btn-warning py-2 px-4">
                        Update Filter <i class="ti ti-chevron-right align-middle ms-2"></i>
                    </button>
                    <a href="{{ route('report.print.low-stock', ['min_stock' => $minStock]) }}" target="_blank" class="btn btn-outline-warning py-2 px-3">
                        <i class="ti ti-printer me-2"></i> Print Report
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h5 class="text-warning">Low Stock Items</h5>
                    <h3 class="text-warning">{{ $lowStockProducts->count() }}</h3>
                    <small class="text-muted">Stock ≤ {{ $minStock }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h5 class="text-danger">Out of Stock</h5>
                    <h3 class="text-danger">{{ $outOfStockProducts->count() }}</h3>
                    <small class="text-muted">Stock = 0</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h5 class="text-info">Total Alert Items</h5>
                    <h3 class="text-info">{{ $lowStockProducts->count() + $outOfStockProducts->count() }}</h3>
                    <small class="text-muted">Requires attention</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Out of Stock Products --}}
    @if($outOfStockProducts->count() > 0)
        <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center mb-4">
                <h6 class="mb-0 text-danger">
                    <i class="ti ti-x-circle fs-5 align-text-top me-1"></i> 
                    Out of Stock Products ({{ $outOfStockProducts->count() }} items)
                </h6>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Product Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Current Stock</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outOfStockProducts as $index => $product)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td class="text-center">{{ $product->category ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($product->harga_satuan, 0, '', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-danger">{{ $product->stok }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">OUT OF STOCK</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Low Stock Products --}}
    @if($lowStockProducts->count() > 0)
        <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
            <div class="d-flex align-items-center mb-4">
                <h6 class="mb-0 text-warning">
                    <i class="ti ti-alert-triangle fs-5 align-text-top me-1"></i> 
                    Low Stock Products ({{ $lowStockProducts->count() }} items)
                </h6>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Product Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Current Stock</th>
                            <th class="text-center">Stock Level</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowStockProducts as $index => $product)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td class="text-center">{{ $product->category ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($product->harga_satuan, 0, '', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $product->stok <= 5 ? 'danger' : 'warning' }}">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $percentage = ($product->stok / $minStock) * 100;
                                    @endphp
                                    <div class="progress" style="height: 20px; width: 80px;">
                                        <div class="progress-bar bg-{{ $percentage <= 25 ? 'danger' : ($percentage <= 50 ? 'warning' : 'info') }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%"
                                             aria-valuenow="{{ $percentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $product->stok <= 5 ? 'danger' : 'warning' }}">
                                        {{ $product->stok <= 5 ? 'CRITICAL' : 'LOW STOCK' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- No Alert Message --}}
    @if($lowStockProducts->count() == 0 && $outOfStockProducts->count() == 0)
        <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
            <div class="text-center py-5">
                <i class="ti ti-check-circle text-success" style="font-size: 4rem;"></i>
                <h4 class="text-success mt-3">All Products are Well Stocked!</h4>
                <p class="text-muted">No products with low stock or out of stock found.</p>
            </div>
        </div>
    @endif
</x-app-layout>