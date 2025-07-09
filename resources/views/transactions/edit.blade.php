<x-app-layout>
    {{-- Page Title --}}
    <x-page-title>Edit Transaction</x-page-title>

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5">
        {{-- form edit data --}}
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="text" name="date" class="form-control datepicker @error('date') is-invalid @enderror" value="{{ old('date', $transaction->date) }}" autocomplete="off">
                        @error('date')
                            <div class="invalid-feedback mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Kolom Customer Dihilangkan --}}

                    <div class="mb-3">
                        <label class="form-label">Product <span class="text-danger">*</span></label>
                        <select id="product" name="product" class="form-select select2-single @error('product') is-invalid @enderror" autocomplete="off">
                            <option selected disabled value="">- Select product -</option>
                            @foreach ($products as $product_item) {{-- Ganti nama variabel agar tidak konflik --}}
                                <option value="{{ $product_item->id }}" data-price="{{ $product_item->price }}" {{ old('product', $transaction->product_id) == $product_item->id ? 'selected' : '' }}>
                                    {{ $product_item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product')
                            <div class="invalid-feedback mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="price" name="price" class="form-control mask-number @error('price') is-invalid @enderror" value="{{ old('price', number_format($transaction->product->price ?? 0, 0, '', '.')) }}" readonly>
                        </div>
                        @error('price')
                            <div class="invalid-feedback mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <hr class="mt-4">

                    <div class="mb-3">
                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" id="qty" name="qty" class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty', $transaction->qty) }}" autocomplete="off" min="1">
                        @error('qty')
                            <div class="invalid-feedback mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="total_display" name="total_display" class="form-control mask-number @error('total') is-invalid @enderror" value="{{ old('total_display', number_format($transaction->total, 0, '', '.')) }}" readonly>
                            <input type="hidden" id="total" name="total" value="{{ old('total', $transaction->total) }}">
                        </div>
                        @error('total')
                            <div class="invalid-feedback mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="mb-3">
                        <label class="form-label">Amount Paid <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="amount_paid_display" name="amount_paid_display" class="form-control mask-number @error('amount_paid') is-invalid @enderror" value="{{ old('amount_paid_display', number_format($transaction->amount_paid, 0, '', '.')) }}">
                            <input type="hidden" id="amount_paid" name="amount_paid" value="{{ old('amount_paid', $transaction->amount_paid) }}">
                        </div>
                         @error('amount_paid')
                            <div class="invalid-feedback mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>
    
            <div class="pt-4 pb-2 mt-5 border-top">
                <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                    <button type="submit" class="btn btn-primary py-2 px-4">Update Transaction</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary py-2 px-3">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            function cleanNumber(value) {
                return value.toString().replace(/\./g, '');
            }

            function formatNumber(value) {
                if (!value && value !== 0) return '';
                return parseFloat(value).toLocaleString('id-ID');
            }

            $('#product').change(function() {
                var price = $(this).children('option:selected').data('price');
                $('#price').val(formatNumber(price));
                calculateTotal();
            });

            $('#qty').on('input change', function() {
                calculateTotal();
            });

            function calculateTotal() {
                var priceText = $('#price').val();
                var qty = $('#qty').val();

                if (!priceText) {
                    $('#total_display').val('');
                    $('#total').val('');
                    return;
                }
                var price = parseFloat(cleanNumber(priceText));

                if (isNaN(price) || price === "" || qty === "" || parseInt(qty) <= 0) {
                    $('#total_display').val('');
                    $('#total').val('');
                     if (qty !== "" && parseInt(qty) <= 0) {
                         $.notify({
                            title: '<h6 class="fw-bold mb-1"><i class="ti ti-circle-x-filled fs-5 align-text-top me-2"></i>Error!</h6>',
                            message: 'Qty must be a positive integer.'
                        }, { type: 'danger', delay: 1000 });
                    }
                    return;
                }
                
                var total = price * parseInt(qty);
                $('#total_display').val(formatNumber(total));
                $('#total').val(total);
            }

            // Inisialisasi perhitungan saat halaman dimuat
            if ($('#product').val()) {
                 // Set harga awal berdasarkan produk yang terpilih
                var initialPrice = $('#product').children('option:selected').data('price');
                if (initialPrice) {
                    $('#price').val(formatNumber(initialPrice));
                }
                calculateTotal(); // Hitung total awal
            }

            $('#amount_paid_display').on('keyup input', function() {
                var displayValue = $(this).val();
                var numericValue = cleanNumber(displayValue);
                $('#amount_paid').val(numericValue);
            }).on('blur', function() {
                 var numericValue = cleanNumber($(this).val());
                 $(this).val(formatNumber(numericValue));
            });
            
            // Format amount_paid_display saat load jika ada value
            if ($('#amount_paid').val()) {
                $('#amount_paid_display').val(formatNumber($('#amount_paid').val()));
            }


            if (!$.fn.datepicker) {
                console.warn('Datepicker library not found.');
            } else {
                 $('.datepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });
            }
            
            if (!$.fn.select2) {
                console.warn('Select2 library not found.');
            } else {
                $('.select2-single').select2({
                    theme: 'bootstrap-5',
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                    placeholder: $(this).data('placeholder'),
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
