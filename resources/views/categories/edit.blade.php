<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Category</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form edit data --}}
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" autocomplete="off">
                    
                    {{-- pesan error untuk name --}}
                    @error('name')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
    
            <div class="pt-4 pb-2 mt-5 border-top">
                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                    {{-- button update data --}}
                    <button type="submit" class="btn btn-primary py-2 px-3">Update</button>
                    {{-- button kembali ke halaman index --}}
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary py-2 px-3">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>