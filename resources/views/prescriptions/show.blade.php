<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Detail Resep Dokter</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-4">
        <dl class="row">
            <dt class="col-sm-3">No. Resep</dt>
            <dd class="col-sm-9">{{ $prescription->no_resep }}</dd>

            <dt class="col-sm-3">Tanggal Resep</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($prescription->tanggal_resep)->format('d-m-Y') }}</dd>

            <dt class="col-sm-3">Nama Dokter</dt>
            <dd class="col-sm-9">{{ $prescription->nama_dokter }}</dd>

            <dt class="col-sm-3">Rumah Sakit</dt>
            <dd class="col-sm-9">{{ $prescription->rumah_sakit }}</dd>

            <dt class="col-sm-3">Nama Pasien</dt>
            <dd class="col-sm-9">{{ $prescription->nama_pasien }}</dd>
        </dl>

        <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-primary">Edit</a>
    </div>
</x-app-layout>
