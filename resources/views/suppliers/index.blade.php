<x-app-layout>
    <x-page-title>Supplier</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="d-grid d-lg-block col-lg-5 col-xl-6 mb-4 mb-lg-0">
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary py-2 px-3">
                <i class="ti ti-plus me-2"></i> Tambah Supplier
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2 shadow-sm pt-4 px-4 pb-3 mb-5">
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped table-hover" style="width:100%">
                <thead>
                    <th class="text-center">No.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Alamat</th>
                    <th class="text-center">No. Telepon</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Actions</th>
                </thead>
                <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td class="text-center">{{ $loop->iteration + ($suppliers->currentPage() - 1) * $suppliers->perPage() }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td class="text-center">
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Detail">
                                <i class="ti ti-list"></i>
                            </a>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Edit">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Delete">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-links">{{ $suppliers->links() }}</div>
    </div>
</x-app-layout>
