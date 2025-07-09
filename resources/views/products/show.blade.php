<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Detail Product</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- tampilkan detail data --}}
        <div class="row flex-lg-row align-items-center g-5">
            <div class="col-lg-3">
                <img src="{{ asset('/storage/products/'.$product->image) }}" class="d-block mx-lg-auto img-thumbnail rounded-4 shadow-sm" alt="Images" loading="lazy">
            </div>
            <div class="col-lg-9">
                <h4>{{ $product->name }}</h4>
                <p class="text-muted"><i class="ti ti-tag me-1"></i> {{ $product->category->name }}</p>
                <p style="text-align: justify">{{ $product->description }}.</p>
                <p class="text-success fw-bold">{{ 'Rp ' . number_format($product->price, 0, '', '.') }}</p>
                <p class="text-success fw-bold"><strong>Harga Satuan: </strong>{{ 'Rp ' . number_format($product->harga_satuan, 0, '', '.') }}</p>
            </div>
        </div>
        <div class="pt-4 pb-2 mt-5 border-top">
            <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                <!-- button kembali ke halaman index -->
                <a href="{{ route('products.index') }}" class="btn btn-secondary py-2 px-4">Close</a>
            </div>
        </div>
    </div>
</x-app-layout>