@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak muncul di topbar --}}

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
@endpush

@section('main-content')

<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            Form Edit Rekap Kerja untuk {{ $rekapKerja->karyawan->nama_lengkap }}
        </div>
        <div class="card-body">
            <form action="{{ route('rekap_kerja.update', $rekapKerja->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $rekapKerja->tanggal }}" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_kerjaan">Jenis Kerjaan</label>
                    <input type="text" name="jenis_kerjaan" id="jenis_kerjaan" class="form-control" value="{{ $rekapKerja->jenis_kerjaan }}" required>
                </div>

                <div class="mb-3">
                    <label for="banyak">Banyak</label>
                    <input type="text" name="banyak" id="banyak" class="form-control" value="{{ $rekapKerja->banyak }}" required>
                </div>

                <div class="mb-3">
                    <label for="upah">Upah (per satuan)</label>
                    <input type="number" step="any" name="upah" id="upah" class="form-control" value="{{ $rekapKerja->upah }}" required>
                </div>

                <p>Jumlah (otomatis): <strong id="jumlah-display">{{ number_format($rekapKerja->jumlah, 2) }}</strong></p>

                <div class="mb-3">
                    <label for="lokasi_sawit_id">Lokasi Sawit</label>
                    <select name="lokasi_sawit_id" id="lokasi_sawit_id" class="form-control" required>
                        <option value="">-- Pilih Lokasi Sawit --</option>
                        @foreach($lokasiSawit as $lokasi)
                            <option value="{{ $lokasi->id }}" {{ $rekapKerja->lokasi_sawit_id == $lokasi->id ? 'selected' : '' }}>
                                {{ $lokasi->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keterangan">Keterangan (optional)</label>
                    <textarea name="keterangan" id="keterangan" class="form-control">{{ $rekapKerja->keterangan }}</textarea>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('rekap_kerja.index') }}" class="btn btn-secondary w-25">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success w-25">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('banyak').addEventListener('input', hitungJumlah);
document.getElementById('upah').addEventListener('input', hitungJumlah);

function hitungJumlah() {
    const banyak = parseFloat(document.getElementById('banyak').value.replace(/[^0-9.,]/g, '').replace(',', '.')) || 0;
    const upah = parseFloat(document.getElementById('upah').value) || 0;
    const jumlah = banyak * upah;

    document.getElementById('jumlah-display').textContent = jumlah.toLocaleString('id-ID', {minimumFractionDigits: 2});
}
</script>

@endsection
