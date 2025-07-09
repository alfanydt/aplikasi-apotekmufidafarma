<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Tambah Obat</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form add data --}}
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select select2-single @error('category') is-invalid @enderror" autocomplete="off">
                        <option disabled selected value="">- Pilih kategori -</option>
                        @foreach ($categories as $category)
                            <option {{ old('category') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="off">
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Jumlah Obat <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah_obat" class="form-control @error('jumlah_obat') is-invalid @enderror" value="{{ old('jumlah_obat') }}" autocomplete="off" min="0">
                    @error('jumlah_obat')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Deskripsi Obat <span class="text-danger">*</span></label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" autocomplete="off">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Supplier <span class="text-danger">*</span></label>
                    <select name="supplier" class="form-select select2-single @error('supplier') is-invalid @enderror" autocomplete="off">
                        <option disabled selected value="">- Select supplier -</option>
                        @foreach ($suppliers as $supplier)
                            <option {{ old('supplier') == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                    <input type="date" name="expired_obat" class="form-control @error('expired_obat') is-invalid @enderror" value="{{ old('expired_obat') }}" autocomplete="off">
                    @error('expired_obat')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Harga Box <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="price" class="form-control mask-number @error('price') is-invalid @enderror" value="{{ old('price') }}" autocomplete="off">
                    </div>
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
                        <input type="text" name="harga_satuan" class="form-control mask-number @error('harga_satuan') is-invalid @enderror" value="{{ old('harga_satuan') }}" autocomplete="off">
                    </div>
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
                        @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4 pb-2 mt-5 border-top">
                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                    <button type="submit" class="btn btn-primary py-2 px-3">Simpan</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary py-2 px-3">Batal</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
