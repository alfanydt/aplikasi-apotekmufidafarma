<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan Per Obat {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            position: relative;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #6861ce;
        }

        .logo {
            position: absolute;
            top: -10px;
            left: 0;
            width: 60px;
            height: 60px;
        }

        .title-center {
            text-align: center;
        }

        .title-center h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }

        .title-center p {
            margin: 3px 0 0;
            font-size: 13px;
        }

        h4 {
            text-align: center;
            margin: 0;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 6px;
        }

        th {
            background-color: #6861ce;
            color: #ffffff;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- Header dengan logo kiri dan nama apotek tengah --}}
    <div class="header">
        <img src="{{ public_path('images/logo-dashboard.png') }}" alt="Logo Apotek" class="logo">
        <div class="title-center">
            <h1>APOTEK MUFIDA FARMA</h1>
            <p>Laporan Penjualan Per Obat</p>
        </div>
    </div>

    <h4>Periode: {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</h4>

    <table style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Harga Satuan (Rp)</th>
                <th>Jumlah Terjual</th>
                <th>Total Pendapatan (Rp)</th>
                <th>Jumlah Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($salesData as $data)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td>{{ $data->product_name }}</td>
                <td align="right">{{ 'Rp ' . number_format($data->unit_price, 0, '', '.') }}</td>
                <td align="center">{{ number_format($data->total_qty) }}</td>
                <td align="right">{{ 'Rp ' . number_format($data->total_revenue, 0, '', '.') }}</td>
                <td align="center">{{ $data->transactions_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">Magetan, {{ date('d F Y') }}</div>

</body>

</html>
