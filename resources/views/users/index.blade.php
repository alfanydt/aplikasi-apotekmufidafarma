<x-app-layout>
    <x-page-title>Data User</x-page-title>
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <div class="icon-circle bg-primary bg-gradient me-3">
                    <i class="ti ti-users text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-dark">Manajemen User</h4>
                    <p class="text-muted mb-0">Kelola data pengguna sistem</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('users.create') }}" class="btn btn-success btn-lg shadow-sm">
                <i class="ti ti-plus me-2"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1 text-white-50">Total Users</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->total() }}</h3>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="ti ti-users fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1 text-white-50">Admin Users</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->where('role', 'admin')->count() }}</h3>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="ti ti-shield-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1 text-white-50">Regular Users</h6>
                            <h3 class="mb-0 fw-bold">{{ $users->where('role', '!=', 'admin')->count() }}</h3>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-20">
                            <i class="ti ti-user fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="ti ti-list me-2 text-primary"></i>Daftar User
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2">
                        <!-- Search functionality could be added here -->
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="ti ti-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Cari user..." id="searchUser">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold" style="width: 60px;">
                                <span class="text-primary">#</span>
                            </th>
                            <th class="fw-bold text-dark">
                                <i class="ti ti-user me-1 text-primary"></i>Nama
                            </th>
                            <th class="fw-bold text-dark">
                                <i class="ti ti-mail me-1 text-primary"></i>Email
                            </th>
                            <th class="fw-bold text-dark">
                                <i class="ti ti-shield me-1 text-primary"></i>Role
                            </th>
                            <th class="text-center fw-bold text-dark" style="width: 180px;">
                                <i class="ti ti-settings me-1 text-primary"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr class="user-row">
                            <td class="text-center">
                                <div class="badge bg-light text-dark fw-bold">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary bg-gradient text-white me-3">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark">{{ $user->name ?? '-' }}</h6>
                                        <small class="text-muted">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-mail me-2 text-muted"></i>
                                    <span class="text-dark">{{ $user->email ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary bg-gradient px-3 py-2 rounded-pill">
                                        <i class="ti ti-crown me-1"></i>Admin
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-gradient px-3 py-2 rounded-pill">
                                        <i class="ti ti-user me-1"></i>{{ ucfirst($user->role ?? 'user') }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <!-- View Button -->
                                    <a href="{{ route('users.show', $user->id) }}" 
                                       class="btn btn-outline-info btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-title="Lihat Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="btn btn-outline-primary btn-sm" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    @if($user->id !== auth()->id())
                                    <form method="POST" 
                                          action="{{ route('users.destroy', $user->id) }}" 
                                          style="display: inline-block;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm"
                                                data-bs-toggle="tooltip" 
                                                data-bs-title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="icon-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px;">
                                        <i class="ti ti-users-off fs-1"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Tidak Ada Data User</h5>
                                    <p class="text-muted mb-3">Belum ada data user yang terdaftar dalam sistem.</p>
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus me-2"></i>Tambah User Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Footer -->
        @if($users->hasPages())
        <div class="card-footer bg-light border-0">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-muted">
                        <i class="ti ti-file-text me-1"></i>
                        Menampilkan <strong>{{ $users->firstItem() ?? 0 }}</strong> - <strong>{{ $users->lastItem() ?? 0 }}</strong> 
                        dari <strong>{{ $users->total() }}</strong> data
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mt-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="icon-circle bg-success bg-gradient text-white me-3">
                <i class="ti ti-check"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="alert-heading mb-1">Berhasil!</h6>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mt-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="icon-circle bg-danger bg-gradient text-white me-3">
                <i class="ti ti-x"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="alert-heading mb-1">Error!</h6>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Custom Styles -->
    <style>
        .icon-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .avatar-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }
        
        .card {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .btn {
            border-radius: 8px;
        }
        
        .badge {
            font-size: 12px;
            font-weight: 500;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9ff;
        }
        
        .user-row {
            transition: all 0.3s ease;
        }
        
        .empty-state .icon-circle {
            width: 80px;
            height: 80px;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-gradient-info {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, #55efc4 0%, #00b894 100%);
        }
        
        .search-highlight {
            background-color: #fff3cd;
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Search functionality
            const searchInput = document.getElementById('searchUser');
            const userRows = document.querySelectorAll('.user-row');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                userRows.forEach(row => {
                    const name = row.querySelector('h6').textContent.toLowerCase();
                    const email = row.querySelector('td:nth-child(3) span').textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                        // Highlight search term
                        if (searchTerm) {
                            row.classList.add('search-highlight');
                        } else {
                            row.classList.remove('search-highlight');
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</x-app-layout>