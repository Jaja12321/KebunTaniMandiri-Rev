<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    </style>
</head>
<body>

<h1>Laporan Bulanan</h1>
<p>Bulan: {{ $bulan }} / Tahun: {{ $tahun }}</p>

@include('laporan_bulanan.partials.operasional')
@include('laporan_bulanan.partials.panen')

<br><br>
<table width="100%">
<tr>
<td>Penanggung Jawab</td>
<td>Pengelola</td>
</tr>
<tr>
<td><br><br><br>_________________</td>
<td><br><br><br>_________________</td>
</tr>
</table>

</body>
</html>
