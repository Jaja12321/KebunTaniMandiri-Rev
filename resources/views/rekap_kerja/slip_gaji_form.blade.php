<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            font-size: 16px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #000;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .footer p {
            font-size: 16px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h2>Slip Gaji Karyawan Kebun Tani Mandiri</h2>
            <p>Periode: Bulan <strong>{{ $bulan }}</strong>, Tahun <strong>{{ $tahun }}</strong></p>
            <p><strong>Nama Karyawan:</strong> {{ $nama_lengkap }}</p> 
        </div>

        <!-- Table for Gaji Details -->
        <table class="table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Gaji</td>
                    <td><strong>Rp {{ number_format($totalGaji, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td>Total Hutang</td>
                    <td><strong>Rp {{ number_format($totalHutang, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td>Sisa Gaji</td>
                    <td><strong>Rp {{ number_format($sisaGaji, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Section -->
<div class="footer">
    <p>Tidar Kuranji, Tanggal {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p style="text-align: center; margin: 30px 0;">Mandor</p>
    <p style="text-align: center; margin-top: 40px;">..................................</p>
</div>

        </div>
    </div>
</body>
</html>
