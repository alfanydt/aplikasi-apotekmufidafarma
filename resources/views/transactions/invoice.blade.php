<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi - {{ $batchId ?? 'N/A' }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            font-family: monospace, 'Courier New', Courier;
            font-size: 10px;
            font-weight: bold;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #000;
            -webkit-font-smoothing: none;
            -moz-osx-font-smoothing: grayscale;
        }

        .invoice-container {
            width: 220px; /* untuk thermal 58mm */
            margin: 0 auto;
            padding: 5px;
        }

        .header-invoice, .footer-invoice {
            text-align: center;
            margin-bottom: 5px;
        }

        .header-invoice h1 {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .header-invoice p,
        .footer-invoice p,
        .transaction-details-invoice p,
        .total-section-invoice p,
        .payment-info p {
            margin: 2px 0;
        }

        .item-table-invoice {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .item-table-invoice th,
        .item-table-invoice td {
            padding: 2px 0;
            font-size: 10px;
        }

        .item-table-invoice th {
            font-weight: bold;
        }

        .item-table-invoice td.qty,
        .item-table-invoice td.price,
        .item-table-invoice td.subtotal {
            text-align: right;
        }

        .item-table-invoice td:first-child,
        .item-table-invoice th:first-child {
            text-align: left;
        }

        .total-section-invoice {
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 5px;
        }

        .footer-invoice {
            border-top: 1px dashed #000;
            padding-top: 5px;
            font-size: 9px;
        }

        .actions {
            margin-top: 10px;
            text-align: center;
        }

        .actions button,
        .actions a {
            background-color: #007bff;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            margin: 2px;
            text-decoration: none;
        }

        .secondary-action {
            background-color: #6c757d;
        }

        .success-action {
            background-color: #28a745 !important;
        }

        @media print {
            body, html {
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-container {
                width: 220px !important;
            }

            .actions {
                display: none;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header-invoice">
            <h1>Struk Pembayaran</h1>
            <p><strong>APOTEK MUFIDA FARMA</strong></p>
            <p>Jl. Raya Tanjung, RT 27 RW 07, Tanjung, Bendo, Magetan</p>
            <p>Telepon: 0812-4981-0212</p>
        </div>

        <div class="transaction-details-invoice">
            @if(isset($batchId))
                <p><strong>No. Transaksi:</strong> {{ $batchId }}</p>
            @else
                <p><strong>No. Transaksi:</strong> {{ $transactions->first()->id ?? 'N/A' }}</p>
            @endif
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transactions->first()->date ?? now())->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}</p>
            <p><strong>Kasir:</strong> {{ auth()->user()->name ?? 'Admin' }}</p>
        </div>

        <div class="item-details-invoice">
            <table class="item-table-invoice">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="qty">Qty</th>
                        <th class="price">Harga</th>
                        <th class="subtotal">Sub</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $grandTotal = 0;
                        $totalItems = 0;
                    @endphp
                    @foreach($transactions as $transaction)
                        @php 
                            $grandTotal += $transaction->total;
                            $totalItems += $transaction->qty;
                        @endphp
                        <tr>
                            <td>{{ $transaction->product->name ?? '-' }}</td>
                            <td class="qty">{{ $transaction->qty }}</td>
                            <td class="price">Rp{{ number_format($transaction->product->harga_satuan ?? 0, 0, ',', '.') }}</td>
                            <td class="subtotal">Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top: 1px dashed #000;">
                        <td><strong>Total Item</strong></td>
                        <td class="qty"><strong>{{ $totalItems }}</strong></td>
                        <td></td>
                        <td class="subtotal"><strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="total-section-invoice">
            <p><strong>TOTAL BAYAR:</strong> Rp{{ number_format($grandTotal, 0, ',', '.') }}</p>
            @if($transactions->first()->amount_paid ?? false)
                @php $kembalian = $transactions->first()->amount_paid - $grandTotal; @endphp
                <p><strong>Tunai:</strong> Rp{{ number_format($transactions->first()->amount_paid, 0, ',', '.') }}</p>
                <p><strong>Kembali:</strong> Rp{{ number_format($kembalian, 0, ',', '.') }}</p>
            @endif
        </div>

        <div class="footer-invoice">
            <p>*** Terima kasih telah berbelanja! ***</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            <p>Simpan struk ini sebagai bukti pembelian</p>
            <p>{{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMMM YYYY - HH:mm:ss') }} WIB</p>
        </div>
    </div>

    <div class="actions">
        <button onclick="window.print()" class="success-action">🖨️ Cetak Struk</button>
        <a href="{{ route('transactions.create') }}" class="success-action">🛒 Transaksi Baru</a>
        <a href="{{ route('transactions.index') }}" class="secondary-action">📋 Lihat Semua Transaksi</a>
    </div>
</body>
</html>
