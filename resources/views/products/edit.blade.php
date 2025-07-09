<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Product</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form edit data --}}
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
            <div class="col-lg-7">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select select2-single @error('category') is-invalid @enderror" autocomplete="off">
                        <option disabled value="">- Select category -</option>
                        @foreach ($categories as $category)
                            <option {{ old('category', $product->category_id) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" autocomplete="off">
                    
                    {{-- pesan error untuk name --}}
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Jumlah Obat <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah_obat" class="form-control @error('jumlah_obat') is-invalid @enderror" value="{{ old('jumlah_obat', $product->stocks->first()->jumlah_obat ?? '') }}" autocomplete="off" min="0">

                    @error('jumlah_obat')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Deskripsi Obat <span class="text-danger">*</span></label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" autocomplete="off">{{ old('description', $product->description) }}</textarea>
                    
                    {{-- pesan error untuk description --}}
                    @error('description')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                    <select name="supplier" class="form-select select2-single @error('supplier') is-invalid @enderror" autocomplete="off">
                        <option disabled value="">- Select supplier -</option>
                        @foreach ($suppliers as $supplier)
                            <option {{ old('supplier', $product->supplier_id) == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Expired Obat <span class="text-danger">*</span></label>
                    <input type="date" name="expired_obat" class="form-control @error('expired_obat') is-invalid @enderror" value="{{ old('expired_obat', $product->stocks->first()->expired_obat ?? '') }}" autocomplete="off">

                    @error('expired_obat')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                    {{-- pesan error untuk category --}}
                    @error('category')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Harga Box <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="price" class="form-control mask-number @error('price') is-invalid @enderror" value="{{ old('price', number_format($product->price, 0, '', '.')) }}" autocomplete="off">
                    </div>
                    
                    {{-- pesan error untuk price --}}
                    @error('price')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="harga_satuan" class="form-control mask-number @error('harga_satuan') is-invalid @enderror" value="{{ old('harga_satuan', number_format($product->harga_satuan, 0, '', '.')) }}" autocomplete="off">
                    </div>
                    
                    {{-- pesan error untuk harga_satuan --}}
                    @error('harga_satuan')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                </div>

                <div class="col-lg-5">
                    <div class="mb-3 ps-xl-3">
                        <label class="form-label">Image</label>
                        <input type="file" accept=".jpg, .jpeg, .png" name="image" id="image" class="form-control @error('image') is-invalid @enderror" autocomplete="off">
            
                        {{-- pesan error untuk image --}}
                        @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- view image --}}
                        <div class="mt-4">
                            <img id="imagePreview" src="{{ asset('/storage/products/'.$product->image) }}" class="img-thumbnail rounded-4 shadow-sm" width="50%" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="pt-4 pb-2 mt-5 border-top">
                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                    {{-- button update data --}}
                    <button type="submit" class="btn btn-primary py-2 px-3">Update</button>
                    {{-- button kembali ke halaman index --}}
                    <a href="{{ route('products.index') }}" class="btn btn-secondary py-2 px-3">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>