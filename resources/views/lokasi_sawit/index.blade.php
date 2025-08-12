@extends('layouts.admin')

@section('page-title', '') {{-- Kosongkan agar tidak tampil di topbar --}}

@section('main-content')

@php
    use Carbon\Carbon;
    $selectedTanggal = request('tanggal', date('Y-m-d'));
@endphp

<!-- Judul -->
<h5 class="mb-4 d-flex align-items-right gap-2"
    style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.5rem; color: #212529;">
    <i class="fas fa-tree text-success"></i> <span>Lokasi Sawit</span>
</h5>

<!-- Success Alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Custom CSS untuk area labels -->
<style>
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

.leaflet-popup-content {
    margin: 12px;
}

.area-label {
    background: none !important;
    border: none !important;
}

.database-marker {
    border: none !important;
    background: transparent !important;
}

.special-marker {
    background-color: #dc3545 !important;
    color: white !important;
    border-radius: 50% !important;
    width: 25px !important;
    height: 25px !important;
    border: 2px solid white !important;
    box-shadow: 0 1px 3px rgba(0,0,0,.5) !important;
}

/* Animation untuk label */
.area-label div {
    animation: labelPulse 2s infinite;
}

@keyframes labelPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Hover effect untuk polygon */
.leaflet-interactive:hover {
    cursor: pointer;
    filter: brightness(1.1);
}

/* Legenda styling */
.legend {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(15px) !important;
    border-radius: 15px !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
    border: 3px solid #28a745 !important;
    z-index: 1000 !important;
}

.legend h4 {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    color: white !important;
    margin: -10px -10px 10px -10px !important;
    padding: 12px !important;
    border-radius: 12px 12px 0 0 !important;
    text-align: center !important;
}

.legend-item {
    padding: 6px 0 !important;
    border-bottom: 1px solid #eee !important;
    display: flex !important;
    align-items: center !important;
}

.legend-item:last-child {
    border-bottom: none !important;
}

/* Info box styling */
.info-box {
    border: none !important;
    background: transparent !important;
}

.leaflet-top.leaflet-left {
    margin-top: 10px !important;
    margin-left: 10px !important;
}

/* Scale control styling */
.leaflet-control-scale {
    background: rgba(255,255,255,0.9) !important;
    border-radius: 8px !important;
    border: 2px solid #28a745 !important;
    font-weight: bold !important;
}

/* Boundary label styling */
.boundary-label {
    border: none !important;
    background: transparent !important;
}

/* Leaflet control positioning */
.leaflet-bottom.leaflet-right {
    margin-bottom: 20px !important;
    margin-right: 20px !important;
}

/* Animation untuk legend */
.legend {
    animation: legendFadeIn 1s ease-in-out;
}

@keyframes legendFadeIn {
    0% { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    100% { 
        opacity: 1; 
        transform: translateY(0); 
    }
}
</style>

<!-- Peta Lokasi Sawit -->
<div id="map" style="height: 400px; border: 1px solid #ddd; margin-bottom: 20px;"></div>

<!-- Toggle Button for Table -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0"><i class="fas fa-table text-primary"></i> Data Lokasi Sawit</h5>
    <button id="toggleTableBtn" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-eye-slash"></i> <span id="toggleText">Sembunyikan Tabel</span>
    </button>
</div>

<!-- Tabel Lokasi Sawit -->
<div id="dataTable" class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if($lokasi_sawit->count() > 0)
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lokasi</th>
                        <th>🌿 Luas Lahan Sawit (ha)</th>
                        <th>Jenis Tanaman</th>
                        <th>Status</th>
                        <th>Koordinat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lokasi_sawit as $lokasi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $lokasi->nama_lokasi }}</strong>
                            @if($lokasi->luas_lahan > 0)
                                <br><small class="badge badge-success">🌿 Lahan Sawit</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-success" style="font-size: 14px;">
                                L = {{ $lokasi->luas_lahan }} Ha
                            </span>
                        </td>
                        <td>
                            <i class="fas fa-seedling text-success"></i> {{ $lokasi->jenis_tanaman }}
                        </td>
                        <td>
                            @if($lokasi->kondisi_tanaman == 'Produktif')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> {{ $lokasi->kondisi_tanaman }}
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $lokasi->kondisi_tanaman }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <small>
                                <strong>Lat:</strong> {{ $lokasi->latitude }}<br>
                                <strong>Lng:</strong> {{ $lokasi->longitude }}
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('lokasi_sawit.edit', $lokasi->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('lokasi_sawit.destroy', $lokasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Tidak ada data lokasi sawit.
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Button Add Location and Back -->
<div class="d-flex justify-content-end gap-2 mb-4">
    <!-- Kembali Button -->
    <a href="{{ route('fitur.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <!-- Tambah Lokasi Sawit Button -->
    <a href="{{ route('lokasi_sawit.create') }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus-circle"></i> Tambah Lokasi Sawit
    </a>
</div>


<script>
    // Inisialisasi peta dengan koordinat tengah yang disesuaikan: 1°32'52"S 103°05'34"E
    var map = L.map('map', {
        center: [-1.547778, 103.092778],
        zoom: 15,
        minZoom: 12,
        maxZoom: 18,
        zoomControl: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | 🌿 Kebun Sawit Manis Madu',
        maxZoom: 18,
    }).addTo(map);

    // Tambahkan kontrol skala
    L.control.scale({
        position: 'bottomleft',
        metric: true,
        imperial: false
    }).addTo(map);

    // Info box untuk menampilkan koordinat mouse
    var infoBox = L.control({position: 'topleft'});
    infoBox.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info-box');
        div.innerHTML = `
            <div id="coordinates-display" style="background: rgba(255,255,255,0.95); 
                                                  padding: 8px 12px; 
                                                  border-radius: 8px; 
                                                  box-shadow: 0 2px 8px rgba(0,0,0,0.2); 
                                                  font-family: monospace; 
                                                  font-size: 11px;
                                                  border: 2px solid #007bff;
                                                  backdrop-filter: blur(5px);">
                <div style="font-weight: bold; color: #007bff; margin-bottom: 2px;">📍 KOORDINAT MOUSE</div>
                <div id="mouse-coords" style="color: #495057;">Hover di peta...</div>
            </div>
        `;
        return div;
    };
    infoBox.addTo(map);

    // Event listener untuk menampilkan koordinat mouse
    map.on('mousemove', function(e) {
        var coords = e.latlng;
        document.getElementById('mouse-coords').innerHTML = 
            'Lat: ' + coords.lat.toFixed(6) + '<br>Lng: ' + coords.lng.toFixed(6);
    });

    // Koordinat batas peta berdasarkan area yang ada dan disesuaikan lebih luas
    var mapBounds = {
        north: -1.525000,  // Utara dari area terjauh
        south: -1.600000,  // Selatan dari area terjauh  
        west: 103.065000,  // Barat dari area terjauh
        east: 103.120000   // Timur dari area terjauh
    };

    // Menggambar batas keseluruhan area peta dengan styling yang lebih baik
    var outerBounds = L.rectangle([
        [mapBounds.south, mapBounds.west],
        [mapBounds.north, mapBounds.east]
    ], {
        color: '#2c3e50',
        weight: 4,
        fillOpacity: 0.05,
        fillColor: '#ecf0f1',
        dashArray: '10, 5'
    }).addTo(map);

    // Menambahkan label untuk batas peta
    var boundaryIcon = L.divIcon({
        className: 'boundary-label',
        html: `<div style="background: rgba(44, 62, 80, 0.9); 
                          color: white; 
                          padding: 6px 12px; 
                          border-radius: 20px; 
                          font-size: 11px; 
                          font-weight: bold;
                          box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                          white-space: nowrap;">
                  📍 BATAS AREA PEMETAAN
               </div>`,
        iconSize: [150, 25],
        iconAnchor: [75, 12]
    });
    
    L.marker([mapBounds.north - 0.005, (mapBounds.west + mapBounds.east) / 2], {
        icon: boundaryIcon
    }).addTo(map);

    // Marker khusus untuk titik tengah JON ALI pada koordinat yang diminta
    var jonAliIcon = L.divIcon({
        className: 'special-marker',
        html: '<div style="background-color: #dc3545; color: white; border-radius: 50%; width: 35px; height: 35px; border: 3px solid white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; box-shadow: 0 3px 8px rgba(0,0,0,0.6);">★</div>',
        iconSize: [35, 35],
        iconAnchor: [17.5, 17.5]
    });

    var jonAliMarker = L.marker([-1.547778, 103.092778], {
        icon: jonAliIcon
    }).addTo(map)
    .bindPopup("<b>JON ALI - TITIK TENGAH</b><br>1°32'52\"S 103°05'34\"E<br><i>Koordinat pusat peta</i>");

    // Area mapping dengan koordinat yang disesuaikan sesuai bentuk asli di peta
    // Semua area termasuk yang tidak memiliki label L= 
    var areas = [
        {
            name: "TONI",
            area: "Area Toni",
            coords: [
                [-1.533000, 103.078000],
                [-1.533000, 103.087000],
                [-1.536000, 103.089000],
                [-1.540000, 103.089000],
                [-1.543000, 103.087000],
                [-1.544000, 103.084000],
                [-1.542000, 103.081000],
                [-1.539000, 103.079000],
                [-1.536000, 103.078000]
            ],
            center: [-1.538000, 103.083000],
            color: '#FF6B6B',
            strokeColor: '#CC4444',
            strokeWidth: 2
        },
        {
            name: "FAUZI", 
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 5.5 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.532000, 103.087000],
                [-1.532000, 103.095000],
                [-1.534000, 103.099000],
                [-1.537000, 103.102000],
                [-1.541000, 103.105000],
                [-1.545000, 103.106000],
                [-1.548000, 103.104000],
                [-1.550000, 103.100000],
                [-1.549000, 103.096000],
                [-1.546000, 103.092000],
                [-1.542000, 103.089000],
                [-1.538000, 103.087000],
                [-1.535000, 103.087000]
            ],
            center: [-1.541000, 103.096000],
            color: '#4ECDC4',
            strokeColor: '#2E8B8B',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "SIANAK",
            area: "Area Sianak",
            coords: [
                [-1.530000, 103.099000],
                [-1.530000, 103.107000],
                [-1.533000, 103.110000],
                [-1.537000, 103.111000],
                [-1.541000, 103.110000],
                [-1.544000, 103.108000],
                [-1.546000, 103.105000],
                [-1.545000, 103.102000],
                [-1.542000, 103.100000],
                [-1.538000, 103.099000],
                [-1.534000, 103.099000]
            ],
            center: [-1.537000, 103.105000],
            color: '#45B7D1',
            strokeColor: '#2E7BB8',
            strokeWidth: 2
        },
        {
            name: "DAYAT",
            area: "Area Dayat",
            coords: [
                [-1.544000, 103.099000],
                [-1.544000, 103.105000],
                [-1.547000, 103.108000],
                [-1.551000, 103.110000],
                [-1.555000, 103.109000],
                [-1.558000, 103.106000],
                [-1.559000, 103.102000],
                [-1.557000, 103.099000],
                [-1.554000, 103.097000],
                [-1.550000, 103.097000],
                [-1.547000, 103.098000]
            ],
            center: [-1.551000, 103.103000],
            color: '#F7DC6F',
            strokeColor: '#D4B942',
            strokeWidth: 2
        },
        {
            name: "BUJANG", 
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 12.99 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.548000, 103.095000],
                [-1.548000, 103.103000],
                [-1.551000, 103.107000],
                [-1.555000, 103.110000],
                [-1.560000, 103.112000],
                [-1.565000, 103.113000],
                [-1.570000, 103.112000],
                [-1.574000, 103.109000],
                [-1.576000, 103.105000],
                [-1.575000, 103.101000],
                [-1.572000, 103.098000],
                [-1.568000, 103.096000],
                [-1.563000, 103.095000],
                [-1.558000, 103.094000],
                [-1.553000, 103.094000]
            ],
            center: [-1.562000, 103.104000],
            color: '#BB8FCE',
            strokeColor: '#8E44AD',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "HUSNAK",
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 2.6 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.550000, 103.082000],
                [-1.550000, 103.089000],
                [-1.553000, 103.092000],
                [-1.557000, 103.094000],
                [-1.562000, 103.095000],
                [-1.567000, 103.094000],
                [-1.570000, 103.091000],
                [-1.571000, 103.087000],
                [-1.569000, 103.083000],
                [-1.566000, 103.081000],
                [-1.562000, 103.080000],
                [-1.557000, 103.080000],
                [-1.553000, 103.081000]
            ],
            center: [-1.560000, 103.087000],
            color: '#85C1E9',
            strokeColor: '#3498DB',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "NGADINO",
            area: "Area Ngadino", 
            coords: [
                [-1.555000, 103.093000],
                [-1.555000, 103.100000],
                [-1.558000, 103.104000],
                [-1.562000, 103.106000],
                [-1.567000, 103.107000],
                [-1.571000, 103.106000],
                [-1.574000, 103.103000],
                [-1.575000, 103.099000],
                [-1.573000, 103.095000],
                [-1.570000, 103.093000],
                [-1.566000, 103.092000],
                [-1.562000, 103.092000],
                [-1.558000, 103.093000]
            ],
            center: [-1.564000, 103.099000],
            color: '#82E0AA',
            strokeColor: '#27AE60',
            strokeWidth: 2
        },
        {
            name: "ADUN",
            area: "Area Adun",
            coords: [
                [-1.545000, 103.082000],
                [-1.545000, 103.089000],
                [-1.548000, 103.092000],
                [-1.552000, 103.094000],
                [-1.556000, 103.093000],
                [-1.559000, 103.091000],
                [-1.560000, 103.087000],
                [-1.558000, 103.084000],
                [-1.555000, 103.082000],
                [-1.551000, 103.081000],
                [-1.548000, 103.081000]
            ],
            center: [-1.552000, 103.087000],
            color: '#F8C471',
            strokeColor: '#F39C12',
            strokeWidth: 2
        },
        {
            name: "GINTING",
            area: "LAHAN SAWIT MANIS MADU",
            areaSize: "L = 40.09 Ha",
            areaType: "Lahan Sawit Manis Madu",
            coords: [
                [-1.545000, 103.070000],
                [-1.542000, 103.075000],
                [-1.544000, 103.080000],
                [-1.548000, 103.082000],
                [-1.552000, 103.081000],
                [-1.557000, 103.080000],
                [-1.562000, 103.080000],
                [-1.567000, 103.081000],
                [-1.572000, 103.082000],
                [-1.577000, 103.082000],
                [-1.582000, 103.081000],
                [-1.585000, 103.078000],
                [-1.586000, 103.074000],
                [-1.584000, 103.070000],
                [-1.580000, 103.068000],
                [-1.575000, 103.067000],
                [-1.570000, 103.068000],
                [-1.565000, 103.069000],
                [-1.560000, 103.070000],
                [-1.555000, 103.070000],
                [-1.550000, 103.070000]
            ],
            center: [-1.565000, 103.076000],
            color: '#58D68D',
            strokeColor: '#229954',
            strokeWidth: 3,
            hasArea: true
        },
        {
            name: "JON ALI",
            area: "Area Jon Ali",
            coords: [
                [-1.545000, 103.090000],
                [-1.545000, 103.095000],
                [-1.548000, 103.096000],
                [-1.551000, 103.095000],
                [-1.552000, 103.092000],
                [-1.550000, 103.090000],
                [-1.548000, 103.089000]
            ],
            center: [-1.547778, 103.092778], // Koordinat tepat yang diminta
            color: '#EC7063',
            strokeColor: '#E74C3C',
            strokeWidth: 2
        },
        {
            name: "MUSA",
            area: "Area Musa",
            coords: [
                [-1.565000, 103.083000],
                [-1.565000, 103.090000],
                [-1.568000, 103.093000],
                [-1.572000, 103.095000],
                [-1.577000, 103.096000],
                [-1.582000, 103.095000],
                [-1.585000, 103.092000],
                [-1.586000, 103.088000],
                [-1.584000, 103.084000],
                [-1.581000, 103.082000],
                [-1.577000, 103.081000],
                [-1.572000, 103.082000],
                [-1.568000, 103.083000]
            ],
            center: [-1.575000, 103.088000],
            color: '#AF7AC5',
            strokeColor: '#8E44AD',
            strokeWidth: 2
        },
        {
            name: "SYAHRIL", 
            area: "Area Syahril",
            coords: [
                [-1.575000, 103.070000],
                [-1.575000, 103.077000],
                [-1.578000, 103.081000],
                [-1.582000, 103.083000],
                [-1.587000, 103.084000],
                [-1.591000, 103.082000],
                [-1.593000, 103.079000],
                [-1.592000, 103.075000],
                [-1.589000, 103.072000],
                [-1.585000, 103.070000],
                [-1.581000, 103.069000],
                [-1.578000, 103.070000]
            ],
            center: [-1.583000, 103.076000],
            color: '#5DADE2',
            strokeColor: '#3498DB',
            strokeWidth: 2
        },
        {
            name: "SADAT",
            area: "Area Sadat",
            coords: [
                [-1.578000, 103.085000],
                [-1.578000, 103.092000],
                [-1.581000, 103.095000],
                [-1.585000, 103.097000],
                [-1.590000, 103.098000],
                [-1.594000, 103.096000],
                [-1.596000, 103.093000],
                [-1.595000, 103.089000],
                [-1.593000, 103.086000],
                [-1.590000, 103.084000],
                [-1.586000, 103.083000],
                [-1.582000, 103.084000]
            ],
            center: [-1.587000, 103.090000],
            color: '#F4D03F',
            strokeColor: '#F1C40F',
            strokeWidth: 2
        },
        // Area tambahan yang terlihat di peta
        {
            name: "GINTING_EXTENSION",
            area: "Area Ginting (Bagian Bawah)",
            coords: [
                [-1.570000, 103.068000],
                [-1.570000, 103.075000],
                [-1.575000, 103.077000],
                [-1.580000, 103.076000],
                [-1.584000, 103.074000],
                [-1.586000, 103.070000],
                [-1.585000, 103.066000],
                [-1.582000, 103.064000],
                [-1.578000, 103.064000],
                [-1.574000, 103.065000]
            ],
            center: [-1.578000, 103.070000],
            color: '#A9DFBF',
            strokeColor: '#52C788',
            strokeWidth: 2
        }
    ];

    // Menambahkan polygon area dan marker untuk setiap area dengan styling yang jelas dan rapi
    areas.forEach(function(area) {
        // Membuat polygon dengan border yang jelas dan warna yang kontras
        var polygon = L.polygon(area.coords, {
            color: area.strokeColor || area.color,
            weight: area.strokeWidth || 3,
            opacity: 1,
            fillColor: area.color,
            fillOpacity: 0.5,
            dashArray: area.hasArea ? null : '8, 5' // Garis putus-putus untuk area tanpa data luas
        }).addTo(map);

        // Menambahkan efek hover untuk interaktivitas yang lebih baik
        polygon.on('mouseover', function (e) {
            this.setStyle({
                weight: (area.strokeWidth || 3) + 2,
                fillOpacity: 0.7,
                color: '#000000'
            });
        });

        polygon.on('mouseout', function (e) {
            this.setStyle({
                weight: area.strokeWidth || 3,
                fillOpacity: 0.5,
                color: area.strokeColor || area.color
            });
        });

        // Menambahkan popup yang informatif dengan label "LAHAN SAWIT MANIS MADU"
        var popupContent = `
            <div style="min-width: 250px; font-family: 'Arial', sans-serif; text-align: center;">
                <div style="background: linear-gradient(135deg, ${area.color}33, ${area.color}66); 
                           padding: 12px; margin: -12px -12px 12px -12px; 
                           border-radius: 12px 12px 0 0; border-bottom: 3px solid ${area.color};">
                    <h4 style="margin: 0; color: #1a1a1a; font-size: 18px; font-weight: bold;">
                        📍 ${area.name}
                    </h4>
                </div>
        `;
        
        if (area.hasArea) {
            popupContent += `
                <div style="background: linear-gradient(135deg, #e8f5e8, #d4edda); 
                           padding: 12px; border-radius: 8px; margin: 8px 0; 
                           border: 2px solid #28a745; box-shadow: 0 2px 4px rgba(40,167,69,0.2);">
                    <div style="font-weight: bold; color: #155724; font-size: 14px; margin-bottom: 4px;">
                        🌿 ${area.area}
                    </div>
                    <div style="color: #28a745; font-size: 16px; font-weight: bold;">
                        ${area.areaSize}
                    </div>
                    <div style="background: #28a745; color: white; padding: 4px 8px; 
                               border-radius: 15px; margin-top: 6px; font-size: 11px;">
                        ✅ Data Luas Tersedia
                    </div>
                </div>
            `;
        } else {
            popupContent += `
                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; 
                           margin: 8px 0; border: 2px solid #6c757d;">
                    <div style="color: #495057; font-size: 14px; font-weight: bold;">
                        ${area.area}
                    </div>
                    <div style="background: #ffc107; color: #212529; padding: 4px 8px; 
                               border-radius: 15px; margin-top: 6px; font-size: 11px;">
                        ⚠️ Belum Ada Data Luas
                    </div>
                </div>
            `;
        }
        
        popupContent += `
                <div style="margin-top: 10px; padding-top: 8px; border-top: 2px solid #eee; 
                           font-size: 12px; color: #6c757d;">
                    📐 Koordinat: ${area.center[0].toFixed(6)}, ${area.center[1].toFixed(6)}
                </div>
            </div>
        `;
        
        polygon.bindPopup(popupContent, {
            maxWidth: 300,
            className: 'custom-popup'
        });

        // Menambahkan label di tengah area dengan label "LAHAN SAWIT MANIS MADU" untuk area yang memiliki data luas
        if (area.hasArea) {
            var labelIcon = L.divIcon({
                className: 'area-label',
                html: `
                    <div style="background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,249,250,0.95)); 
                               border: 3px solid ${area.color}; 
                               border-radius: 15px; 
                               padding: 8px 12px; 
                               font-weight: bold; 
                               text-align: center; 
                               box-shadow: 0 4px 8px rgba(0,0,0,0.3); 
                               white-space: nowrap; 
                               min-width: 120px;
                               backdrop-filter: blur(5px);">
                        <div style="font-size: 9px; color: #28a745; margin-bottom: 2px; font-weight: bold;">
                            🌿 LAHAN SAWIT MANIS MADU
                        </div>
                        <div style="font-size: 13px; font-weight: bold; color: ${area.color}; margin: 2px 0;">
                            ${area.name}
                        </div>
                        <div style="font-size: 11px; color: #28a745; font-weight: bold; margin-top: 2px;">
                            ${area.areaSize}
                        </div>
                    </div>
                `,
                iconSize: [130, 60],
                iconAnchor: [65, 30]
            });
            
            L.marker(area.center, {
                icon: labelIcon
            }).addTo(map);
        } else {
            // Label sederhana untuk area tanpa data luas
            var simpleLabelIcon = L.divIcon({
                className: 'area-label',
                html: `
                    <div style="background: rgba(255,255,255,0.9); 
                               border: 2px solid ${area.color}; 
                               border-radius: 8px; 
                               padding: 6px 10px; 
                               font-weight: bold; 
                               text-align: center; 
                               box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                               backdrop-filter: blur(3px);">
                        <div style="font-size: 12px; color: ${area.color}; font-weight: bold;">
                            ${area.name}
                        </div>
                        <div style="font-size: 9px; color: #666; margin-top: 1px;">
                            Area Lain
                        </div>
                    </div>
                `,
                iconSize: [80, 35],
                iconAnchor: [40, 17]
            });
            
            L.marker(area.center, {
                icon: simpleLabelIcon
            }).addTo(map);
        }
    });

    // Marker dari database lokasi sawit yang sudah ada
    @foreach($lokasi_sawit as $lokasi)
        L.marker([{{ $lokasi->latitude }}, {{ $lokasi->longitude }}], {
            icon: L.divIcon({
                className: 'database-marker',
                html: '<div style="background-color: #28a745; color: white; border-radius: 50%; width: 20px; height: 20px; border: 2px solid white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 10px;">DB</div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        })
        .addTo(map)
        .bindPopup("<b>{{ $lokasi->nama_lokasi }}</b><br>{{ $lokasi->jenis_tanaman }}<br>{{ $lokasi->kondisi_tanaman }}<br><small>Data dari Database</small>");
    @endforeach

    // Menambahkan legenda peta yang informatif dan menarik
    var legend = L.control({position: 'bottomright'});
    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = `
            <div style="background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(248,249,250,0.95)); 
                        padding: 18px; 
                        border-radius: 15px; 
                        box-shadow: 0 6px 20px rgba(0,0,0,0.25); 
                        font-family: 'Arial', sans-serif; 
                        min-width: 280px;
                        border: 3px solid #28a745;
                        backdrop-filter: blur(10px);">
                
                <div style="background: linear-gradient(135deg, #28a745, #20c997); 
                           color: white; 
                           margin: -18px -18px 15px -18px; 
                           padding: 12px 18px; 
                           border-radius: 12px 12px 0 0; 
                           text-align: center;
                           font-weight: bold;
                           font-size: 14px;">
                    🗺️ LEGENDA PETA SAWIT MANIS MADU
                </div>
                
                <div style="background: linear-gradient(135deg, #e8f5e8, #d4edda); 
                           padding: 10px; 
                           border-radius: 8px; 
                           border-left: 4px solid #28a745; 
                           margin-bottom: 10px;">
                    <div style="display: flex; align-items: center; margin-bottom: 6px;">
                        <span style="color: #28a745; font-size: 16px; margin-right: 8px;">🌿</span> 
                        <span style="font-weight: bold; color: #155724; font-size: 13px;">LAHAN SAWIT MANIS MADU</span>
                    </div>
                    <div style="font-size: 10px; color: #155724; margin-left: 24px; line-height: 1.4;">
                        ✅ Area dengan Label "L=" (Data Luas Tersedia)<br>
                        📊 4 Area - Total: 61.18 Ha (49.07%)
                    </div>
                </div>
                
                <div style="background: #e3f2fd; 
                           padding: 8px; 
                           border-radius: 8px; 
                           border-left: 4px solid #2196f3; 
                           margin-bottom: 10px;">
                    <div style="display: flex; align-items: center;">
                        <span style="color: #1976d2; font-size: 14px; margin-right: 8px;">▢</span> 
                        <span style="font-size: 11px; color: #0d47a1; font-weight: bold;">BATAS AREA PEMETAAN</span>
                    </div>
                    <div style="font-size: 9px; color: #1976d2; margin-left: 22px;">
                        Koordinat: 1°31'30"S - 1°36'00"S<br>
                        103°03'54"E - 103°07'12"E
                    </div>
                </div>
                
                <hr style="margin: 12px 0; border: none; border-top: 2px solid #e9ecef;">
                
                <div style="text-align: center;">
                    <div style="font-weight: bold; color: #28a745; font-size: 12px; margin-bottom: 2px;">
                        🏆 KEBUN SAWIT MANIS MADU
                    </div>
                    <div style="font-size: 10px; color: #6c757d; line-height: 1.3;">
                        📊 Total 14 Area | 📏 124.68 Ha<br>
                        🌿 Lahan Sawit Premium | 🗓️ ${new Date().getFullYear()}
                    </div>
                </div>
            </div>
        `;
        return div;
    };
    legend.addTo(map);

    // Menambahkan kontrol zoom yang responsif dengan fokus area
    map.fitBounds([
        [mapBounds.south, mapBounds.west],
        [mapBounds.north, mapBounds.east]
    ], {
        padding: [30, 30]
    });

    // Table Toggle Functionality
    document.getElementById('toggleTableBtn').addEventListener('click', function() {
        const dataTable = document.getElementById('dataTable');
        const toggleBtn = this;
        const toggleText = document.getElementById('toggleText');
        const icon = toggleBtn.querySelector('i');
        
        if (dataTable.style.display === 'none') {
            // Show table
            dataTable.style.display = 'block';
            toggleText.textContent = 'Sembunyikan Tabel';
            icon.className = 'fas fa-eye-slash';
            toggleBtn.classList.remove('btn-outline-success');
            toggleBtn.classList.add('btn-outline-primary');
            
            // Resize map back to normal
            document.getElementById('map').style.height = '400px';
        } else {
            // Hide table
            dataTable.style.display = 'none';
            toggleText.textContent = 'Tampilkan Tabel';
            icon.className = 'fas fa-eye';
            toggleBtn.classList.remove('btn-outline-primary');
            toggleBtn.classList.add('btn-outline-success');
            
            // Expand map for better visibility
            document.getElementById('map').style.height = '600px';
        }
        
        // Trigger map resize after DOM changes
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    });
    
    // Add smooth transition for table
    document.getElementById('dataTable').style.transition = 'all 0.3s ease-in-out';
    document.getElementById('map').style.transition = 'height 0.3s ease-in-out';
</script>

@endsection
