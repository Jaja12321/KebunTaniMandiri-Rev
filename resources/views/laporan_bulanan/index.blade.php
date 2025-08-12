@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

<h5 class="mb-4 d-flex align-items-center gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-seedling text-success"></i> <span>Laporan Bulanan</span>
</h5>

<form method="GET" action="{{ route('laporan_bulanan.index') }}" class="mb-">
    <div class="row justify-content-start">
        <div class="col-sm-1 col-md-2 form-group">
            <label for="bulan">Bulan</label>
            <select name="bulan" id="bulan" class="form-control">
                <option value="1" {{ $bulan == 1 ? 'selected' : '' }}>Januari</option>
                <option value="2" {{ $bulan == 2 ? 'selected' : '' }}>Februari</option>
                <option value="3" {{ $bulan == 3 ? 'selected' : '' }}>Maret</option>
                <option value="4" {{ $bulan == 4 ? 'selected' : '' }}>April</option>
                <option value="5" {{ $bulan == 5 ? 'selected' : '' }}>Mei</option>
                <option value="6" {{ $bulan == 6 ? 'selected' : '' }}>Juni</option>
                <option value="7" {{ $bulan == 7 ? 'selected' : '' }}>Juli</option>
                <option value="8" {{ $bulan == 8 ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{ $bulan == 9 ? 'selected' : '' }}>September</option>
                <option value="10" {{ $bulan == 10 ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{ $bulan == 11 ? 'selected' : '' }}>November</option>
                <option value="12" {{ $bulan == 12 ? 'selected' : '' }}>Desember</option>
            </select>
        </div>

        <div class="col-sm-1 col-md-2 form-group">
            <label for="tahun">Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ $tahun }}" max="2099" min="2020" placeholder="Tahun">
        </div>

        <div class="col-sm-2 col-md-2 form-group d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Terapkan Filter</button>
        </div>
    </div>
</form>



<!-- Button untuk mengunduh PDF -->
<a href="{{ route('laporan_bulanan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-primary mb-4">
    <i class="fas fa-file-pdf"></i> Cetak PDF
</a>

<!-- Tabel Pengeluaran Operasional -->
<div class="card mb-4">
    <div class="card-header">
        <h4>Pengeluaran Operasional</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Item</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rawat as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->banyak }}</td>
                        <td>{{ number_format($item->harga, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->jumlah, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @foreach ($rekapKerja as $key => $item)
                    <tr>
                        <td>{{ $key + count($rawat) + 1 }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->jenis_kerjaan }}</td>
                        <td>{{ $item->banyak }}</td>
                        <td>{{ number_format($item->upah, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->jumlah, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tabel Hasil Panen -->
<div class="card">
    <div class="card-header">
        <h4>Hasil Panen</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Lokasi</th>
                    <th>Berat (kg)</th>
                    <th>Harga (Rp/kg)</th>
                    <th>Total Nilai (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($panen as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->lokasiSawit->nama_lokasi ?? 'N/A' }}</td>
                        <td>{{ $item->berat }}</td>
                        <td>{{ number_format($item->harga_tbs, 2, ',', '.') }}</td>
                        <td>{{ number_format($item->total_nilai, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Tombol Kembali ke Fitur -->
<div class="text-right mb-4">
    <a href="{{ route('fitur.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali 
    </a>
</div>

@endsection
