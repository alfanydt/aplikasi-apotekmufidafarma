<x-app-layout>
    <x-page-title>Tambah Supplier</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="off" required>
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" autocomplete="off">
                @error('address')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" autocomplete="off">
                @error('phone')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="off">
                @error('email')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                <button type="submit" class="btn btn-primary py-2 px-3">Simpan</button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary py-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
