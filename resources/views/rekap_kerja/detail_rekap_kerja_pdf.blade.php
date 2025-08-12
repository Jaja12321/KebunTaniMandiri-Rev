<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekap Kerja - {{ $nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 14px;
            color: #333;
            margin: 0 0 10px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #007BFF;
            color: #fff;
            font-weight: bold;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer .signature {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
            text-align: center;
            padding-top: 10px;
        }

        .footer .total-row {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Detail Rekap Kerja Karyawan: {{ $nama_lengkap }}</h2>

        @php
            // Ensure bulan is an integer and pass to Carbon
            $bulan = intval($bulan);
            $monthName = \Carbon\Carbon::create()->month($bulan)->format('F');
        @endphp
        
        <p>Periode: Bulan {{ $monthName }} Tahun {{ $tahun }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Lokasi</th>
                    <th>Banyak</th>
                    <th>Upah (Rp)</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekapKerja as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->jenis_kerjaan }}</td>
                        <td>{{ optional($item->lokasiSawit)->nama_lokasi ?? '-' }}</td>
                        <td>{{ $item->banyak }}</td>
                        <td>Rp {{ number_format($item->upah, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <!-- Footer Row with Total Gaji, Hutang, and Sisa Gaji -->
                <tr class="footer total-row">
                    <td colspan="5" style="text-align: left;">Total Gaji:</td>
                    <td>Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
                </tr>
                <tr class="footer total-row">
                    <td colspan="5" style="text-align: left;">Total Hutang:</td>
                    <td>Rp {{ number_format($totalHutang, 0, ',', '.') }}</td>
                </tr>
                <tr class="footer total-row">
                    <td colspan="5" style="text-align: left;">Sisa Gaji:</td>
                    <td>Rp {{ number_format($sisaGaji, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
    <p>Tidar Kuranji, Tanggal {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p style="text-align: center; margin: 30px 0;">Mandor</p>
    <p style="text-align: center; margin-top: 40px;">..................................</p>
</div>
        </div>
    </div>

</body>
</html>
