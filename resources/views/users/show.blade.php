<x-app-layout>
    <x-page-title>Detail User</x-page-title>

    <div class="bg-white rounded shadow-sm p-4">
        <h5>Nama: {{ $user->name }}</h5>
        <h6>Role: {{ ucfirst($user->role) }}</h6>

        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</x-app-layout>
