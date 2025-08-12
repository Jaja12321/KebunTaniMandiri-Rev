@extends('layouts.admin')

@section('page-title', '') {{-- kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 650px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white  font-weight-bold text-center">
            Form Tambah / Kurangi Hutang
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('rekap_kerja.proses_hutang') }}">
                @csrf
                <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                <div class="form-group">
                    <label for="tanggal">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>

                <div class="form-group mt-3">
                    <label for="tipe">Jenis Transaksi</label>
                    <select name="tipe" id="tipe" class="form-control" required>
                        <option value="tambah">Tambah Hutang</option>
                        <option value="kurangi">Kurangi Hutang</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="jumlah">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                </div>

                <div class="form-group mt-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group mt-4 text-right">
                    <a href="{{ route('rekap_kerja.detail', $karyawan->id) }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
