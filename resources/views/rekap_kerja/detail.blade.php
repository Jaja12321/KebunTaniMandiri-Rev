@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak muncul di topbar --}}

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
@endpush

@section('main-content')

<h5 class="mb-3 d-flex align-items-center gap-2"
    style="font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <span>Detail Rekap Kerja dan Gaji</span>
</h5>

{{-- Filter Form and Print Button --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    {{-- Filter Form --}}
    <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
        <form method="GET" action="{{ route('rekap_kerja.detail', ['id' => $karyawan->id]) }}" class="d-flex align-items-center gap-2">
            <div class="input-group input-group-sm" style="max-width: 150px;">
                <span class="input-group-text bg-white">
                    <i class="fas fa-calendar-month text-primary"></i>
                </span>
                <select name="bulan" class="form-control" required>
                    <option value="">Pilih Bulan</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ $selectedBulan == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group input-group-sm" style="max-width: 120px;">
                <span class="input-group-text bg-white">
                    <i class="fas fa-calendar-year text-primary"></i>
                </span>
                <input type="number" name="tahun" class="form-control" value="{{ $selectedTahun ?? date('Y') }}" min="2020" max="{{ date('Y') }}" required>
            </div>

            <button type="submit" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                <i class="fas fa-search"></i> <span>Cari</span>
            </button>
        </form>
    </div>
</div>

<div class="table-responsive" style="font-family: 'Inter', sans-serif; table-layout: fixed;">
    <table class="table table-bordered align-middle text-center">
        <thead class="table-dark text-white">
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 10%;">Jenis Pekerjaan</th>
                <th style="width: 10%;">Lokasi</th>
                <th style="width: 10%;">Banyak(kg)</th>
                <th style="width: 10%;">Upah (Rp)</th>
                <th style="width: 10%;">Jumlah (Rp)</th>
                <th style="width: 10%;">Aksi</th> <!-- Removed Keterangan column -->
            </tr>
        </thead>
        <tbody>
            @foreach($rekapGabungan as $index => $item)
                <tr style="background-color: {{ $item['jenis'] === 'Lembur' ? '#fff8e1' : '#f8f9fa' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}</td>
                    <td>{{ $item['jenis_kerjaan'] }}</td>
                    <td>{{ $item['lokasi'] ?? '-' }}</td> <!-- Tampilkan lokasi atau default -->
                    <td>{{ $item['banyak'] }}</td>
                    <td>Rp {{ number_format($item['upah'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
<td style="display: flex; justify-content: space-between; align-items: center;">
    <!-- Edit Button (Blue Color and Smaller Size) -->
    <a href="{{ route('rekap_kerja.edit', $item['id']) }}" class="btn btn-primary btn-sm" style="font-size: 11px; padding: 5px 10px; margin-right: 5px;">
        <i class="fas fa-edit"></i> Edit
    </a>
    
    <!-- Delete Button (Smaller Size) -->
    <form action="{{ route('rekap_kerja.destroy', $item['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" style="font-size: 11px; padding: 5px 10px;">
            <i class="fas fa-trash"></i> Hapus
        </button>
    </form>
</td>


                </tr>
            @endforeach
        </tbody>

        <tfoot class="text-sm font-weight-bold text-left">
            <tr class="table-primary">
                <td colspan="6">Total Gaji</td>
                <td>Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="table-danger">
                <td colspan="6">Total Hutang</td>
                <td>Rp {{ number_format($totalHutang, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr class="table-success">
                <td colspan="6">Sisa Gaji</td>
                <td>Rp {{ number_format($sisaGaji, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

{{-- Button Alignment Fix --}}
<div class="d-flex justify-content-between gap-3 mt-3">
    {{-- Print Button at the Bottom Left --}}
    <div>
        <a href="{{ route('rekap_kerja.generateRekapKerjaPDF', ['id' => $karyawan->id, 'bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Print Rekap Kerja
        </a>

        <!-- Button for Generating Slip Gaji PDF -->
        <a href="{{ route('rekap_kerja.generateSlipGajiPDF', ['id' => $karyawan->id, 'bulan' => $selectedBulan, 'tahun' => $selectedTahun]) }}" class="btn btn-warning">
            <i class="fas fa-file-pdf"></i> Print Slip Gaji
        </a>
    </div>

    {{-- Action Buttons --}}
    <div>
        <a href="{{ route('rekap_kerja.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('rekap_kerja.form_hutang', $karyawan->id) }}" class="btn btn-danger">
            <i class="fas fa-balance-scale"></i> Tambah / Kurangi Hutang
        </a>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
