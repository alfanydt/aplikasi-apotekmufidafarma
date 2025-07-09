<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Tambah Resep Dokter</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        <form action="{{ route('prescriptions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">No. Resep <span class="text-danger">*</span></label>
                <input type="text" name="no_resep" class="form-control @error('no_resep') is-invalid @enderror" value="{{ old('no_resep') }}" autocomplete="off">
                @error('no_resep')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Resep <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_resep" class="form-control @error('tanggal_resep') is-invalid @enderror" value="{{ old('tanggal_resep') }}" autocomplete="off">
                @error('tanggal_resep')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                <input type="text" name="nama_dokter" class="form-control @error('nama_dokter') is-invalid @enderror" value="{{ old('nama_dokter') }}" autocomplete="off">
                @error('nama_dokter')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rumah Sakit <span class="text-danger">*</span></label>
                <input type="text" name="rumah_sakit" class="form-control @error('rumah_sakit') is-invalid @enderror" value="{{ old('rumah_sakit') }}" autocomplete="off">
                @error('rumah_sakit')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                <input type="text" name="nama_pasien" class="form-control @error('nama_pasien') is-invalid @enderror" value="{{ old('nama_pasien') }}" autocomplete="off">
                @error('nama_pasien')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="pt-4 pb-2 mt-5 border-top">
                <button type="submit" class="btn btn-primary py-2 px-3">Save</button>
                <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary py-2 px-3">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
