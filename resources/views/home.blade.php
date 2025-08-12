@extends('layouts.admin')

@section('page-title', '')

@section('main-content')

<div class="d-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-dark font-weight-bold">
        <i class="fas fa-home mr-2"></i>Dashboard
    </h1>
    <small class="text-muted ml-3">Welcome back, <strong>{{ Auth::user()->name }}</strong>!</small>
</div>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('status'))
<div class="alert alert-success border-left-success" role="alert">
    {{ session('status') }}
</div>
@endif

<!-- Card Summary -->
<div class="container my-4">
    <div class="row g-4">
        @foreach ([
            ['title' => 'Jumlah Karyawan', 'value' => $jumlahKaryawan, 'icon' => 'users', 'color' => 'primary'],
            ['title' => 'Panen Bulan Ini (Kg)', 'value' => number_format($panenBulanIni, 0, ',', '.'), 'icon' => 'tractor', 'color' => 'info'],
            ['title' => 'Kehadiran Hari Ini', 'value' => $kehadiranHariIni, 'icon' => 'calendar-check', 'color' => 'warning'],
            ['title' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalPendapatan, 0, ',', '.'), 'icon' => 'dollar-sign', 'color' => 'warning'],
            ['title' => 'Total Pengeluaran', 'value' => 'Rp ' . number_format($totalPengeluaran, 0, ',', '.'), 'icon' => 'credit-card', 'color' => 'danger'],
        ] as $card)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 border-start border-4 border-{{ $card['color'] }}">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-uppercase text-{{ $card['color'] }} fw-bold">{{ $card['title'] }}</small>
                        <h4 class="mb-0 fw-bold text-dark">{{ $card['value'] }}</h4>
                    </div>
                    <i class="fas fa-{{ $card['icon'] }} fa-2x text-{{ $card['color'] }} opacity-25"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Charts and Table Section -->
<div class="container my-4">
    <div class="row mb-4">
        <!-- Produksi Panen Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header font-weight-bold">Produksi Panen Per Bulan (Kg)</div>
                <div class="card-body">
                    <canvas id="produksiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pendapatan Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header font-weight-bold">Pendapatan Per Bulan (Rp)</div>
                <div class="card-body">
                    <canvas id="pendapatanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Pengeluaran Chart and Status Tanaman Table (Aligned) -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header font-weight-bold">Pengeluaran Per Bulan (Rp)</div>
                <div class="card-body">
                    <canvas id="pengeluaranChart"></canvas>
                </div>
            </div>
        </div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Produksi Panen Chart
    const ctxProduksi = document.getElementById('produksiChart').getContext('2d');
    new Chart(ctxProduksi, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Total Berat Panen (Kg)',
                data: @json($produksiData),
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pendapatan Chart
    const ctxPendapatan = document.getElementById('pendapatanChart').getContext('2d');
    new Chart(ctxPendapatan, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($pendapatanData),
                fill: true,
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.3)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Pengeluaran Chart
    const ctxPengeluaran = document.getElementById('pengeluaranChart').getContext('2d');
    new Chart(ctxPengeluaran, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Pengeluaran (Rp)',
                data: @json($pengeluaranData),
                fill: true,
                borderColor: 'rgba(220, 53, 69, 1)',
                backgroundColor: 'rgba(220, 53, 69, 0.3)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
