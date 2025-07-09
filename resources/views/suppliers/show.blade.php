<x-app-layout>
    <x-page-title>Supplier Details</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        <div class="mb-3">
            <label class="form-label fw-bold">Name:</label>
            <div>{{ $supplier->name }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Address:</label>
            <div>{{ $supplier->address ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Phone:</label>
            <div>{{ $supplier->phone ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email:</label>
            <div>{{ $supplier->email ?? '-' }}</div>
        </div>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary py-2 px-3">Back to List</a>
    </div>
</x-app-layout>
