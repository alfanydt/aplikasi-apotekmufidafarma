<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Resep Dokter</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <form action="{{ route('prescriptions.update', $prescription->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="no_resep" class="form-label">No. Resep</label>
                <input type="text" class="form-control @error('no_resep') is-invalid @enderror" id="no_resep" name="no_resep" value="{{ old('no_resep', $prescription->no_resep) }}" required>
                @error('no_resep')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_resep" class="form-label">Tanggal Resep</label>
                <input type="date" class="form-control @error('tanggal_resep') is-invalid @enderror" id="tanggal_resep" name="tanggal_resep" value="{{ old('tanggal_resep', $prescription->tanggal_resep) }}" required>
                @error('tanggal_resep')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_dokter" class="form-label">Nama Dokter</label>
                <input type="text" class="form-control @error('nama_dokter') is-invalid @enderror" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $prescription->nama_dokter) }}" required>
                @error('nama_dokter')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="rumah_sakit" class="form-label">Rumah Sakit</label>
                <input type="text" class="form-control @error('rumah_sakit') is-invalid @enderror" id="rumah_sakit" name="rumah_sakit" value="{{ old('rumah_sakit', $prescription->rumah_sakit) }}" required>
                @error('rumah_sakit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror" id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien', $prescription->nama_pasien) }}" required>
                @error('nama_pasien')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</x-app-layout>
