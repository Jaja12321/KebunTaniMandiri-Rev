@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')
<div class="container" style="max-width: 900px;">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white font-weight-bold text-center">
            History Kehadiran
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Attendance History Table -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark text-white small">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Jam Kerja</th>
                            <th>Gaji Lembur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawan->kehadiran as $index => $attendance)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $attendance->status == 'Hadir' ? 'success' : ($attendance->status == 'Izin' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td>{{ $attendance->waktu_masuk ?? '-' }}</td>
                                <td>{{ $attendance->waktu_keluar ?? '-' }}</td>
                                <td>{{ $attendance->jam_kerja ?? '-' }}</td>
                                <td>{{ $attendance->gaji_lembur ? 'Rp ' . number_format($attendance->gaji_lembur, 0, ',', '.') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data kehadiran untuk karyawan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back Button at the Bottom Right -->
        <div class="card-footer text-end">
            <a href="{{ route('kehadiran.index') }}" class="btn btn-md btn-secondary text-white fw-semibold px-4 py-2 shadow-sm">
                <i class="fas fa-arrow-left"></i> <span>Kembali</span>
            </a>
        </div>
    </div>
</div>
@endsection
