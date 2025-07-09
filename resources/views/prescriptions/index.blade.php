<x-app-layout>
{{-- Page Title --}}
<x-page-title>Resep Dokter</x-page-title>

<div class="bg-white rounded-2 shadow-sm p-4 mb-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">
            <i class="ti ti-plus me-1"></i> Tambah Resep Dokter
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No. Resep</th>
                    <th>Tanggal Resep</th>
                    <th>Nama Dokter</th>
                    <th>Rumah Sakit</th>
                    <th>Nama Pasien</th>
                    <th width="180" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->no_resep }}</td>
                    <td>{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d-m-Y') }}</td>
                    <td>{{ $prescription->nama_dokter }}</td>
                    <td>{{ $prescription->rumah_sakit }}</td>
                    <td>{{ $prescription->nama_pasien }}</td>
                    <td class="text-center">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('prescriptions.edit', $prescription->id) }}" 
                            class="btn btn-primary btn-sm m-1" 
                            data-bs-tooltip="tooltip" 
                            data-bs-title="Edit">
                            <i class="ti ti-edit"></i>
                        </a>
                        
                        {{-- Tombol Hapus dengan Modal --}}
                        <button type="button" 
                                class="btn btn-danger btn-sm m-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDelete{{ $prescription->id }}" 
                                data-bs-tooltip="tooltip" 
                                data-bs-title="Delete">
                            <i class="ti ti-trash"></i>
                        </button>
                    </td>
                </tr>

                {{-- Modal hapus data --}}
                <div class="modal fade" id="modalDelete{{ $prescription->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    <i class="ti ti-trash me-2"></i> Delete Resep Dokter
                                </h1>
                            </div>
                            <div class="modal-body">
                                {{-- informasi data yang akan dihapus --}}
                                <p class="mb-2">
                                    Apakah Anda yakin ingin menghapus resep dokter <span class="fw-bold mb-2">{{ $prescription->no_resep }}</span>?
                                </p>
                                <div class="alert alert-warning" role="alert">
                                    <i class="ti ti-alert-triangle me-2"></i>
                                    Tindakan ini tidak dapat dibatalkan!
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary py-2 px-3" data-bs-dismiss="modal">Batal</button>
                                {{-- button hapus data --}}
                                <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger py-2 px-3">Ya, hapus!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="ti ti-info-circle fs-5 me-2"></i>
                            <div>No data available.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination jika diperlukan --}}
    @if(method_exists($prescriptions, 'links'))
        <div class="d-flex justify-content-center mt-3">
            {{ $prescriptions->links() }}
        </div>
    @endif
</div>

{{-- JavaScript untuk Bootstrap tooltips --}}
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-tooltip="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Menampilkan pesan sukses/error jika ada
    @if(session('success'))
        // Bisa menggunakan Toast atau Alert sesuai framework yang digunakan
        alert('{{ session('success') }}');
    @endif

    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
</x-app-layout>