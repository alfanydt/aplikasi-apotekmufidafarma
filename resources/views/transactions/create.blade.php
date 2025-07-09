<x-app-layout>
    {{-- Judul Halaman --}}

    <div class="bg-white rounded-2 shadow-sm p-4 mb-5" style="min-height: 600px;">
        <form action="{{ route('transactions.store') }}" method="POST" id="posForm">
            @csrf

            <div class="d-flex" style="height: 100%;">
                {{-- Sisi kiri: Keranjang --}}
                <div class="flex-grow-1 me-4" style="min-width: 400px; max-width: 450px; border: 1px solid #ddd; border-radius: 8px; padding: 15px; display: flex; flex-direction: column; max-height: 620px;">
    <h4 class="mb-3">Keranjang</h4>

    <div style="flex-grow: 1; overflow-y: auto; max-height: 350px;">
        <table class="table table-bordered" id="cartTable" style="min-width: 100%;">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Item keranjang akan dimuat secara dinamis --}}
            </tbody>
        </table>
    </div>

    <div class="mt-3 pt-3 border-top">
        <div class="mb-3">
            <label for="totalPayment" class="form-label fw-bold">Total Pembayaran</label>
            <input type="text" id="totalPayment" name="total_payment" class="form-control fs-5 fw-bold" readonly />
        </div>

        <div class="mb-3">
            <label for="amountPaid" class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
            <input type="number" id="amountPaid" name="amount_paid" class="form-control" min="0" autocomplete="off" required />
        </div>

        <input type="hidden" id="cartData" name="cart_data" />

        <button id="completeBtn" type="submit" class="btn btn-success w-100 py-3 fs-5 fw-bold" disabled>Selesaikan Transaksi</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
    </div>
</div>

                {{-- Sisi kanan: Pemilihan Produk --}}
                <div class="flex-grow-1" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; display: flex; flex-direction: column;">
                    
                    <div class="row mb-3 align-items-end">
                        <div class="col-md-6">
                            <label for="productSearch" class="form-label">Cari Obat</label>
                            <input type="text" id="productSearch" class="form-control" placeholder="Cari nama obat..." autocomplete="off" />
                        </div>
                        <div class="col-md-3">
                            <label for="productQty" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" id="productQty" class="form-control" min="1" value="1" autocomplete="off" />
                        </div>
                        <div class="col-md-3">
                            <label for="stockInfo" class="form-label">Stok Tersedia</label>
                            <input type="number" id="stockInfo" class="form-control" readonly />
                        </div>
                    </div>

                    <button type="button" id="addToCartBtn" class="btn btn-primary mb-3" disabled>Tambah ke Keranjang</button>

                    <div class="mb-3" style="overflow-y: auto; flex-grow: 1;">
                        <label class="form-label">Pilih Obat</label>
                        <div id="productGrid" class="row g-3" style="max-height: 500px; overflow-y: auto;">
                            @foreach ($products as $product)
                            <div class="col-4 col-md-3">
                                <div class="card h-100 product-card" 
                                     data-id="{{ $product->id }}"
                                     data-price="{{ $product->harga_satuan ?? $product->price }}"
                                     data-stock="{{ $product->stocks->first()->jumlah_obat ?? 0 }}"
                                     style="cursor: pointer; user-select: none;">
                                    @if($product->image_url ?? false)
                                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 120px; object-fit: contain; padding: 10px; background: #f8f9fa;">
                                    @else
                                    <div style="height: 120px; display: flex; align-items: center; justify-content: center; background: #f0f0f0; font-weight: 700; font-size: 12px; color: #666;">
                                        Tidak ada gambar
                                    </div>
                                    @endif
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1" style="font-size: 0.9rem; min-height: 40px;">{{ $product->name }}</h6>
                                        <p class="card-text fw-bold mb-0 text-primary" style="font-size: 0.85rem;">{{ number_format($product->harga_satuan ?? $product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Bagian JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productQty = document.getElementById('productQty');
        const stockInfo = document.getElementById('stockInfo');
        const cartTableBody = document.querySelector('#cartTable tbody');
        const totalPaymentInput = document.getElementById('totalPayment');
        const cartDataInput = document.getElementById('cartData');
        const completeBtn = document.getElementById('completeBtn');
        const amountPaidInput = document.getElementById('amountPaid');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const productGrid = document.getElementById('productGrid');
        const productSearch = document.getElementById('productSearch');

        let selectedProduct = null;
        let cart = [];

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(value);
        }

        productSearch.addEventListener('input', function () {
        const query = productSearch.value.trim();
        if (query.length === 0) {
            return; // biarkan default jika kosong
        }

        fetch(`/products/search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                productGrid.innerHTML = ''; // kosongkan dulu grid-nya
                data.forEach(product => {
                    const card = document.createElement('div');
                    card.className = 'col-4 col-md-3';

                    const stock = product.stocks[0]?.jumlah_obat ?? 0;
                    const price = product.harga_satuan ?? product.price;

                    card.innerHTML = `
                        <div class="card h-100 product-card"
                            data-id="${product.id}"
                            data-price="${price}"
                            data-stock="${stock}"
                            style="cursor: pointer; user-select: none;">
                            ${
                                product.image_url
                                ? `<img src="${product.image_url}" class="card-img-top" alt="${product.name}" style="height: 120px; object-fit: contain; padding: 10px; background: #f8f9fa;">`
                                : `<div style="height: 120px; display: flex; align-items: center; justify-content: center; background: #f0f0f0; font-weight: 700; font-size: 12px; color: #666;">
                                        Tidak ada gambar
                                   </div>`
                            }
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1" style="font-size: 0.9rem; min-height: 40px;">${product.name}</h6>
                                <p class="card-text fw-bold mb-0 text-primary" style="font-size: 0.85rem;">${formatCurrency(price)}</p>
                            </div>
                        </div>
                    `;
                    productGrid.appendChild(card);
                });

                clearSelection(); // reset pilihan
            });
    });
        function getRemainingStock(productId) {
            const productCard = productGrid.querySelector(`.product-card[data-id="${productId}"]`);
            if (!productCard) return 0;
            const originalStock = parseInt(productCard.getAttribute('data-stock'), 10);
            const inCartItem = cart.find(item => item.id == productId);
            const qtyInCart = inCartItem ? inCartItem.quantity : 0;
            return originalStock - qtyInCart;
        }

        function updateCartTable() {
            cartTableBody.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${formatCurrency(item.price)}</td>
                    <td>${item.quantity}</td>
                    <td>${formatCurrency(subtotal)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-btn" data-index="${index}">Hapus</button></td>
                `;
                cartTableBody.appendChild(row);
            });

            totalPaymentInput.value = total > 0 ? total : '';
            cartDataInput.value = JSON.stringify(cart);

            validatePayment();
        }

        function validatePayment() {
            const total = cart.reduce((acc, item) => acc + item.price * item.quantity, 0);
            const amountPaid = parseInt(amountPaidInput.value, 10);

            if (!isNaN(amountPaid) && amountPaid >= total && total > 0) {
                completeBtn.disabled = false;
            } else {
                completeBtn.disabled = true;
            }
        }

        function updateStockInfo() {
            if (!selectedProduct) {
                stockInfo.value = '';
                productQty.value = 1;
                addToCartBtn.disabled = true;
                return;
            }

            const productId = selectedProduct.getAttribute('data-id');
            const remainingStock = getRemainingStock(productId);

            stockInfo.value = remainingStock >= 0 ? remainingStock : 0;

            const qty = parseInt(productQty.value, 10);
            addToCartBtn.disabled = !selectedProduct || qty < 1 || qty > remainingStock;
        }

        function clearSelection() {
            if (selectedProduct) {
                selectedProduct.classList.remove('selected');
            }
            selectedProduct = null;
            stockInfo.value = '';
            productQty.value = 1;
            addToCartBtn.disabled = true;
        }

        function filterProducts() {
            const query = productSearch.value.toLowerCase().trim();
            productGrid.querySelectorAll('.product-card').forEach(card => {
                const name = card.querySelector('.card-title').innerText.toLowerCase();
                card.style.display = name.includes(query) ? '' : 'none';
            });
        }

        productGrid.addEventListener('click', function(e) {
            const card = e.target.closest('.product-card');
            if (!card) return;

            if (selectedProduct) {
                selectedProduct.classList.remove('selected');
            }

            card.classList.add('selected');
            selectedProduct = card;
            updateStockInfo();
        });

        productQty.addEventListener('input', function() {
            updateStockInfo();
        });

        productSearch.addEventListener('input', function() {
            filterProducts();
            clearSelection();
        });

        addToCartBtn.addEventListener('click', function() {
            if (!selectedProduct) return;

            const productId = selectedProduct.getAttribute('data-id');
            const productName = selectedProduct.querySelector('.card-title').innerText;
            const productPrice = parseInt(selectedProduct.getAttribute('data-price'), 10);
            const qty = parseInt(productQty.value, 10);

            const remainingStock = getRemainingStock(productId);

            if (qty < 1) {
                alert('Jumlah harus minimal 1.');
                return;
            }

            if (qty > remainingStock) {
                alert('Jumlah melebihi stok tersedia.');
                return;
            }

            // Tambah atau update keranjang
            const inCartItem = cart.find(item => item.id == productId);
            if (inCartItem) {
                inCartItem.quantity += qty;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: qty
                });
            }

            updateCartTable();

            // Reset qty dan update stok info tapi tidak clear selection
            productQty.value = 1;
            updateStockInfo();
        });

        cartTableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                const index = parseInt(e.target.getAttribute('data-index'), 10);
                if (index >= 0 && index < cart.length) {
                    const removedItem = cart[index];
                    cart.splice(index, 1);
                updateCartTable();
                updateStockInfo();
            }
        }
    });

    amountPaidInput.addEventListener('input', function() {
        validatePayment();
    });

    // Inisialisasi awal
    updateCartTable();
    clearSelection();
});
</script> 
</x-app-layout>
