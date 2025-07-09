<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Laporan</x-page-title>

    <!-- Hero Section -->
    <div class="bg-gradient-primary rounded-3 shadow-sm p-4 mb-4 text-white">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="mb-2 fw-bold">📊 Pusat Laporan</h4>
                <p class="mb-0 opacity-75">Akses berbagai laporan untuk analisis bisnis dan monitoring performa</p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="ti ti-chart-bar" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    <!-- Report Cards Grid -->
    <div class="row g-4">
        <!-- Laporan Laba Rugi Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 report-card">
                <div class="card-body p-4 position-relative">
                    <!-- Decorative Icon -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <i class="ti ti-currency-dollar text-success" style="font-size: 1.5rem; opacity: 0.4;"></i>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="report-icon bg-success bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="ti ti-chart-line text-success" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-2">Laporan Laba Rugi</h5>
                            <p class="card-text text-muted mb-3">
                                Analisis pendapatan, biaya, dan profitabilitas bisnis dalam periode tertentu
                            </p>
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <i class="ti ti-clock me-1"></i>
                                <span>Real-time data</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('profit-loss.show') }}" class="btn btn-success w-100">
                        <i class="ti ti-eye me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Penjualan Per Obat Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 report-card">
                <div class="card-body p-4 position-relative">
                    <!-- Decorative Icon -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <i class="ti ti-pill text-primary" style="font-size: 1.5rem; opacity: 0.4;"></i>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="report-icon bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="ti ti-package text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title fw-bold mb-2">Laporan Penjualan Obat</h5>
                            <p class="card-text text-muted mb-3">
                                Detail penjualan setiap produk obat dengan analisis performa dan tren penjualan
                            </p>
                            <div class="d-flex align-items-center text-muted small mb-3">
                                <i class="ti ti-chart-dots me-1"></i>
                                <span>Analisis produk</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('sales-by-product.show') }}" class="btn btn-primary w-100">
                        <i class="ti ti-eye me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border-end border-light-subtle h-100 d-flex flex-column justify-content-center py-3">
                                <i class="ti ti-report text-info mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-bold mb-1">Laporan Tersedia</h6>
                                <span class="text-muted small">2 Jenis Laporan</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border-end border-light-subtle h-100 d-flex flex-column justify-content-center py-3">
                                <i class="ti ti-clock text-warning mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-bold mb-1">Update Real-time</h6>
                                <span class="text-muted small">Data Terkini</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="h-100 d-flex flex-column justify-content-center py-3">
                                <i class="ti ti-download text-success mb-2" style="font-size: 2rem;"></i>
                                <h6 class="fw-bold mb-1">Export Ready</h6>
                                <span class="text-muted small">Format PDF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .report-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .report-icon {
            min-width: 60px;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
        }

        .btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .report-card {
                margin-bottom: 1rem;
            }

            .border-end {
                border-right: none !important;
                border-bottom: 1px solid var(--bs-border-color-translucent) !important;
            }
        }
    </style>
</x-app-layout>
