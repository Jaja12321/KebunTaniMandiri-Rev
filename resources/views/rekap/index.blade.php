@extends('layouts.admin')

@section('page-title', '')

@section('main-content')

{{-- Title and Filter Form --}}
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <h5 class="mb-0 font-weight-bold" style="font-family: 'Poppins', sans-serif;">
        🌴 Rekap Produksi Sawit
    </h5>
    {{-- Filter Bulan dan Tahun --}}
    <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
        <form method="GET" action="{{ route('rekap.index') }}" class="d-flex align-items-center gap-3">
            <!-- Filter Bulan -->
            <div class="input-group input-group-sm" style="max-width: 180px;">
                <span class="input-group-text bg-white">
                    <i class="fas fa-calendar-month text-primary"></i>
                </span>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Input Tahun -->
            <div class="input-group input-group-sm" style="max-width: 120px;">
                <span class="input-group-text bg-white">
                    <i class="fas fa-calendar-year text-primary"></i>
                </span>
                <input type="number" name="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}" min="2020" max="{{ date('Y') }}" required>
            </div>

            <button type="submit" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
                <i class="fas fa-search"></i> <span>Cari</span>
            </button>
        </form>
    </div>
</div>

{{-- Box Card for the Table --}}
<div class="card shadow-sm mb-4">
    <div class="card-body p-4">
        {{-- Table for Produksi Data --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-100 align-middle text-center mb-0">
                <thead class="table-dark text-white small">
                    <tr>
                        <th style="width: 25%;">Nama Kebun</th>
                        <th>Termin 1 (kg)</th>
                        <th>Termin 2 (kg)</th>
                        <th>Termin 3 (kg)</th>
                        <th>Total (kg)</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($lokasiSawits as $lokasi)
                        @php
                            $lokasiProduksi = $produksiData->has($lokasi->id) ? $produksiData[$lokasi->id] : collect();
                            $termin1 = $lokasiProduksi->where('termin', 'Termin 1')->first()->total_berat ?? 0;
                            $termin2 = $lokasiProduksi->where('termin', 'Termin 2')->first()->total_berat ?? 0;
                            $termin3 = $lokasiProduksi->where('termin', 'Termin 3')->first()->total_berat ?? 0;
                            $jumlah  = $termin1 + $termin2 + $termin3;
                        @endphp
                        <tr>
                            <td class="text-left">{{ $lokasi->nama_lokasi }}</td>
                            <td>{{ number_format($termin1, 2, ',', '.') }}</td>
                            <td>{{ number_format($termin2, 2, ',', '.') }}</td>
                            <td>{{ number_format($termin3, 2, ',', '.') }}</td>
                            <td class="font-weight-bold">{{ number_format($jumlah, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot style="background-color: #a1e6d7;">
                    <tr class="font-weight-bold text-center">
                        <td class="text-left">Total produksi</td>
                        <td>{{ number_format($totalTermin['Termin 1'] ?? 0, 2, ',', '.') }}</td>
                        <td>{{ number_format($totalTermin['Termin 2'] ?? 0, 2, ',', '.') }}</td>
                        <td>{{ number_format($totalTermin['Termin 3'] ?? 0, 2, ',', '.') }}</td>
                        <td>{{ number_format($totalProduksi, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- Action Buttons (outside card and below the table) --}}
<div class="d-flex justify-content-end gap-2 mt-3">
    <a href="{{ route('fitur.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('rekap.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank"
       class="btn btn-success btn-sm shadow-sm">
        <i class="fas fa-file-pdf"></i> Cetak PDF
    </a>
</div>

@endsection
