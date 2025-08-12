<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Laporan Keuangan Kebun Tani Mandiri</title>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }
    header, footer {
        text-align: center;
        margin-bottom: 20px;
    }
    header h1 {
        font-size: 22px;
        margin-bottom: 10px;
    }
    footer {
        position: fixed;
        bottom: 20px;
        width: 100%;
    }
    footer .signature {
        margin-top: 50px;
        display: inline-block;
        text-align: center;
        width: 30%;
    }
    footer .signature span {
        display: block;
        margin-top: 50px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .table-title {
        font-weight: bold;
        margin-top: 20px;
    }
    .total-row td {
        font-weight: bold;
        text-align: right;
    }
    .page-header {
        margin-bottom: 20px;
        text-align: center;
        font-size: 18px;
    }
</style>
</head>
<body>

<!-- Header Section -->
<header>
    <div class="page-header">
        <h1>Laporan Keuangan Kebun Tani Mandiri</h1>
        @if($tanggal)
            <p>Tanggal: {{ $tanggal }}</p>
        @endif
    </div>
</header>

<!-- Pendapatan Section -->
<section>
    <h4 class="table-title">Pendapatan</h4>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jumlah (Rp)</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendapatan as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total Pendapatan</strong></td>
                <td><strong>{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</section>

<!-- Pengeluaran Section -->
<section>
    <h4 class="table-title">Pengeluaran</h4>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jumlah (Rp)</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengeluaran as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $item->keterangan }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td><strong>Total Pengeluaran</strong></td>
                <td><strong>{{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</section>

<!-- Selisih Section -->
<section>
    <h4 class="table-title">Selisih</h4>
    <table>
        <tbody>
            <tr>
                <td><strong>Selisih</strong></td>
                <td><strong>{{ number_format($selisih, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</section>

<footer>
    <div class="footer-container" style="display: flex; justify-content: space-between; width: 100%; padding: 0 10px;">
        <!-- Left Footer Section -->
        <div class="footer" style="text-align: center; flex: 1; padding-left: 10px;">
            <p>Tidar Kuranji, Tanggal {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
            <p style="margin: 30px 0;">Mandor</p>
            <p style="margin-top: 40px;">..................................</p>
        </div>
</footer>


</body>
</html>
