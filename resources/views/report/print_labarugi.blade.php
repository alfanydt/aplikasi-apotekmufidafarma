<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Laba Rugi {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</title>
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
            <p>Laporan Laba Rugi</p>
        </div>
    </div>

    <h4>Periode: {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</h4>

    <table style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Produk</th>
                <th>Total Kuantitas</th>
                <th>Total Pendapatan (Rp)</th>
                <th>Total Biaya (Rp)</th>
                <th>Laba (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($productDetails as $detail)
            <tr>
                <td align="center">{{ $no++ }}</td>
                <td>{{ $detail->product_name }}</td>
                <td align="center">{{ number_format($detail->total_qty) }}</td>
                <td align="right">{{ 'Rp ' . number_format($detail->total_revenue, 0, '', '.') }}</td>
                <td align="right">{{ 'Rp ' . number_format($detail->total_cost, 0, '', '.') }}</td>
                <td align="right">{{ 'Rp ' . number_format($detail->profit, 0, '', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @php
                $totalRevenue = 0;
                $totalCost = 0;
                $grossProfit = 0;
            @endphp

            @foreach ($productDetails as $detail)
                @php
                    $totalRevenue += $detail->total_revenue;
                    $totalCost += $detail->total_cost;
                    $grossProfit += $detail->profit;
                @endphp
            @endforeach
            <tr>
                <th colspan="3" style="text-align: right;">Total</th>
                <th style="text-align: right;">{{ 'Rp ' . number_format($totalRevenue, 0, '', '.') }}</th>
                <th style="text-align: right;">{{ 'Rp ' . number_format($totalCost, 0, '', '.') }}</th>
                <th style="text-align: right;">{{ 'Rp ' . number_format($grossProfit, 0, '', '.') }}</th>
            </tr>
        </tfoot>

    </table>

    <div class="footer">Magetan, {{ date('d F Y') }}</div>

</body>

</html>
