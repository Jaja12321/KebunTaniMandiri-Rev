@extends('layouts.admin')

@section('page-title')
<div class="d-flex align-items-center gap-2">
    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2"
        style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
        🛠️ Fitur
    </h5>
</div>
@endsection

@section('main-content')

<!-- FITUR GRID -->
<div class="row justify-content-center mt-4">
    @php
        $fitur = [
    ['title' => 'Data Karyawan', 'icon' => 'users', 'route' => 'karyawan.index', 'color' => 'primary'],
    ['title' => 'Kehadiran', 'icon' => 'calendar-check', 'route' => 'kehadiran.index', 'color' => 'info'],
    ['title' => 'Panen', 'icon' => 'leaf', 'route' => 'panen.index', 'color' => 'success'],
    ['title' => 'Rawat', 'icon' => 'tools', 'route' => 'rawat.index', 'color' => 'warning'],
    ['title' => 'Rekap Kerja dan Gaji', 'icon' => 'clipboard-list', 'route' => 'rekap_kerja.index', 'color' => 'secondary'],
    ['title' => 'Rekap Produksi', 'icon' => 'chart-bar', 'route' => 'rekap.index', 'color' => 'purple'],
    ['title' => 'Laporan Bulanan', 'icon' => 'file-alt', 'route' => 'laporan_bulanan.index', 'color' => 'secondary'],
    ['title' => 'Laporan Keuangan', 'icon' => 'file-invoice-dollar', 'route' => 'laporan.keuangan', 'color' => 'dark'],
    ['title' => 'Lokasi Sawit', 'icon' => 'map-marker-alt', 'route' => 'lokasi_sawit.index', 'color' => 'teal'],
        ];
    @endphp

    @foreach ($fitur as $item)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <a href="{{ route($item['route']) }}" class="text-decoration-none">
                <div class="card fitur-card shadow-sm h-100 text-center border-0">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-circle bg-{{ $item['color'] }}">
                            <i class="fas fa-{{ $item['icon'] }}"></i>
                        </div>
                        <h6 class="mt-3 text-uppercase text-{{ $item['color'] }}">{{ $item['title'] }}</h6>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<!-- STYLE -->
<style>
    .fitur-card {
        transition: all 0.3s ease-in-out;
        border-radius: 12px;
    }
    .fitur-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        color: white;
    }
    .bg-purple { background-color: #6f42c1; }
    .text-purple { color: #6f42c1; }
    .bg-teal { background-color: #20c997; }
    .text-teal { color: #20c997; }
    a.text-decoration-none:hover {
        text-decoration: none;
    }
</style>

@endsection
