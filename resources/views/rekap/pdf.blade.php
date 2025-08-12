<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Produksi Panen - PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #e0e0e0;
        }
        h2 {
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<h2>REKAP HASIL PRODUKSI BERSIH KEBUN TANI MANDIRI (KTM)</h2>
<p style="text-align: center;">PRIDE: {{ $bulan }} / {{ $tahun }}</p>

<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>NAMA KEBUN</th>
            <th>ROTASI KE-1 (kg)</th>
            <th>ROTASI KE-2 (kg)</th>
            <th>ROTASI KE-3 (kg)</th>
            <th>JUMLAH (kg)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lokasiSawits as $index => $lokasi)
            @php
                $lokasiProduksi = $produksiData->has($lokasi->id) ? $produksiData[$lokasi->id] : collect();
                $termin1 = $lokasiProduksi->where('termin', 'Termin 1')->first()->total_berat ?? 0;
                $termin2 = $lokasiProduksi->where('termin', 'Termin 2')->first()->total_berat ?? 0;
                $termin3 = $lokasiProduksi->where('termin', 'Termin 3')->first()->total_berat ?? 0;
                $jumlah  = $termin1 + $termin2 + $termin3;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $lokasi->nama_lokasi }}</td>
                <td>{{ number_format($termin1, 2, ',', '.') }}</td>
                <td>{{ number_format($termin2, 2, ',', '.') }}</td>
                <td>{{ number_format($termin3, 2, ',', '.') }}</td>
                <td><strong>{{ number_format($jumlah, 2, ',', '.') }}</strong></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">Subtotal</th>
            <th>{{ number_format($totalTermin['Termin 1'] ?? 0, 2, ',', '.') }}</th>
            <th>{{ number_format($totalTermin['Termin 2'] ?? 0, 2, ',', '.') }}</th>
            <th>{{ number_format($totalTermin['Termin 3'] ?? 0, 2, ',', '.') }}</th>
            <th>{{ number_format($totalProduksi, 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>

<div class="footer">
    <p>Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p>Mandor</p>
    <p>..................................</p>
</div>

</body>
</html>
