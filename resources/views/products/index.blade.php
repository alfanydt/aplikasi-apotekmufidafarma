<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Obat</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <div class="row">
            <div class="d-grid d-lg-block col-lg-5 col-xl-6 mb-4 mb-lg-0">
                {{-- button form add data --}}
                <a href="{{ route('products.create') }}" class="btn btn-primary py-2 px-3">
                    <i class="ti ti-plus me-2"></i> Tambah Obat
                </a>
            </div>
            <div class="col-lg-7 col-xl-6">
                {{-- form pencarian --}}
                <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center justify-content-end gap-2">
                    <div>
                        <select name="perPage" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>Show 10</option>
                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>Show 20</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input id="searchProduct" type="text" name="search" class="form-control form-search py-2" value="{{ request('search') }}" placeholder="Cari obat ..." autocomplete="off">

                        <!-- <input type="text" name="search" class="form-control form-search py-2" value="{{ request('search') }}" placeholder="Search product ..." autocomplete="off">
                        <button class="btn btn-primary py-2" type="submit">Search</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2 shadow-sm pt-4 px-4 pb-3 mb-5">
        {{-- tabel tampil data --}}
        <!-- <div id="productTable"> -->
        <div class="table-responsive mb-3">
            <table class="table table-bordered table-striped table-hover" style="width:100%">
                <thead>
                    <th class="text-center">No.</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Jumlah Obat</th>
                    <th class="text-center">Expired Obat</th>
                    <th class="text-center">Actions</th>
                </thead>
                <tbody>
                @php $i = 0; @endphp
                @forelse ($products as $product)
                    {{-- jika data ada, tampilkan data --}}
                    <tr>
                        <td width="30" class="text-center">{{ ++$i }}</td>
                        <td width="50" class="text-center">
                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="img-thumbnail rounded-4" width="80" alt="Images">
                        </td>
                        <td width="150">{{ $product->name }}</td>
                        <td width="80" class="text-end">{{ 'Rp ' . number_format($product->price, 0, '', '.') }}</td>
                        <td width="100" class="text-center">{{ $product->stocks->first()->jumlah_obat ?? '-' }}</td>
                        <td width="120" class="text-center">{{ $product->stocks->first()->expired_obat ?? '-' }}</td>
                        <td width="100" class="text-center">
                            {{-- button form detail data --}}
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Detail">
                                <i class="ti ti-list"></i>
                            </a>
                            {{-- button form edit data --}}
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Edit">
                                <i class="ti ti-edit"></i>
                            </a>
                            {{-- button modal hapus data --}}
                            <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $product->id }}" data-bs-tooltip="tooltip" data-bs-title="Delete"> 
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Modal hapus data --}}
                    <div class="modal fade" id="modalDelete{{ $product->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        <i class="ti ti-trash me-2"></i> Delete Product
                                    </h1>
                                </div>
                                <div class="modal-body">
                                    {{-- informasi data yang akan dihapus --}}
                                    <p class="mb-2">
                                        Are you sure to delete <span class="fw-bold mb-2">{{ $product->name }}</span>?
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary py-2 px-3" data-bs-dismiss="modal">Cancel</button>
                                    {{-- button hapus data --}}
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger py-2 px-3"> Yes, delete it! </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- jika data tidak ada, tampilkan pesan data tidak tersedia --}}
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
        {{-- pagination --}}
        <div class="pagination-links">{{ $products->links() }}</div>
    </div>
</x-app-layout>
<!-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchProduct');
    const container = document.getElementById('productTable');
    let timeout = null;

    input.addEventListener('input', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const search = input.value;
            const perPage = document.querySelector('select[name="perPage"]').value;

            fetch(`/products?search=${encodeURIComponent(search)}&perPage=${perPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.querySelector('#productTable');
                container.innerHTML = newTable.innerHTML;
            });
        }, 300);
    });
});
</script>
@endpush -->

</create_file>
