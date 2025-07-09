{{-- Navbar Top --}}
<nav class="navbar navbar-top fixed-top bg-white shadow-sm">
    <div class="container">
        <a class="d-inline navbar-brand text-success" href="#">
            <img src="{{ asset('images/logo-dashboard.png') }}" alt="Logo" width="32" class="d-inline-block align-text-top me-2">
            <span class="fs-4 text-uppercase fw-semibold">Apotek Mufida Farma</span>
        </a>
    </div>
</nav>

{{-- Navbar Menu --}}
<nav class="navbar navbar-menu fixed-top navbar-expand-lg bg-light shadow-lg-sm">
    <div class="container">
        <div class="collapse navbar-collapse">
                <ul class="navbar-nav">

                @if(Auth::user() && Auth::user()->role === 'admin')
                <li class="nav-item">
                    <x-navbar-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <i class="ti ti-home align-text-top me-1"></i> Dashboard
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')">
                        <i class="ti ti-category align-text-top me-1"></i> Kategori Obat
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                        <i class="ti ti-copy align-text-top me-1"></i> Data Obat
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('suppliers.index') }}" :active="request()->routeIs('suppliers.*')">
                        <i class="ti ti-truck align-text-top me-1"></i> Data Supplier
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('report.index') }}" :active="request()->routeIs('report.*')">
                        <i class="ti ti-file-text align-text-top me-1"></i> Laporan
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('prescriptions.index') }}" :active="request()->routeIs('prescriptions.*')">
                        <i class="ti ti-file-text align-text-top me-1"></i> Resep Dokter
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                        <i class="ti ti-users align-text-top me-1"></i> Data User
                    </x-navbar-link>
                </li>
                @endif

                @if(Auth::user() && Auth::user()->role === 'kasir')
                <li class="nav-item">
                    <x-navbar-link href="{{ route('transactions.index') }}" :active="request()->routeIs('transactions.*')">
                        <i class="ti ti-folders align-text-top me-1"></i> Transactions
                    </x-navbar-link>
                </li>
                <li class="nav-item">
                    <x-navbar-link href="{{ route('resep-transactions.index') }}" :active="request()->routeIs('resep-transactions.*')">
                        <i class="ti ti-stethoscope align-text-top me-1"></i> Resep Dokter
                    </x-navbar-link>
                </li>
                @endif

                @if(Auth::user() && Auth::user()->role !== 'kasir')
                {{-- Removed About menu as per user request --}}
                {{-- <li class="nav-item">
                    <x-navbar-link href="{{ route('about') }}" :active="request()->routeIs('about')">
                        <i class="ti ti-info-circle align-text-top me-1"></i> About
                    </x-navbar-link>
                </li> --}}
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
