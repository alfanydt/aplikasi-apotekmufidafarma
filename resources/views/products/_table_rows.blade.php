@php
use Carbon\Carbon;
@endphp

@forelse ($products as $product)
    @php
        $expiredDate = $product->stocks->first()->expired_obat ?? null;
        $isExpired = $expiredDate ? Carbon::parse($expiredDate)->isPast() : false;
    @endphp
    <tr>
        <td class="text-center">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
        <td class="text-center">
            <img src="{{ asset('/storage/products/'.$product->image) }}" class="img-thumbnail rounded-4" width="80" alt="Images">
        </td>
        <td>{{ $product->name }}</td>
        <td class="text-end">{{ 'Rp ' . number_format($product->price, 0, '', '.') }}</td>
        <td class="text-center">{{ $product->stocks->first()->jumlah_obat ?? '-' }}</td>
        <td class="text-center">
            {{ $expiredDate ?? '-' }}
            @if($isExpired)
                <span class="text-danger ms-2" title="Expired">
                    <i class="ti ti-alert-circle"></i>
                </span>
            @endif
        </td>
        <td class="text-center">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Detail">
                <i class="ti ti-list"></i>
            </a>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm m-1" data-bs-tooltip="tooltip" data-bs-title="Edit">
                <i class="ti ti-edit"></i>
            </a>
            <button type="button" class="btn btn-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#modalDelete{{ $product->id }}" data-bs-tooltip="tooltip" data-bs-title="Delete"> 
                <i class="ti ti-trash"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">
            <div class="d-flex justify-content-center align-items-center">
                <i class="ti ti-info-circle fs-5 me-2"></i>
                <div>No data available.</div>
            </div>
        </td>
    </tr>
@endforelse
