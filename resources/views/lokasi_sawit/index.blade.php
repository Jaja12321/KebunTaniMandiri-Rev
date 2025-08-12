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
            @if($lokasiSawit2->count() > 0) 
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
                    @foreach($lokasiSawit2 as $lokasi) 
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $lokasi->nama_lokasi }}</strong></td>
                        <td>
                            <span class="badge badge-success">
                                {{ $lokasi->area_size ? $lokasi->area_size . ' Ha' : '-' }}
                            </span>
                        </td>
                        <td>{{ $lokasi->area_type }}</td>
                        <td>
                            @if($lokasi->has_area == 1)
                                <span class="badge badge-success">Produktif</span>
                            @else
                                <span class="badge badge-warning">Tidak Produktif</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $defaultCoords = [
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
                                ];
                                $coordsToShow = ($lokasi->coords && is_array($lokasi->coords) && count($lokasi->coords) > 0) ? $lokasi->coords : $defaultCoords;
                            @endphp
                            <small>
                                @foreach($coordsToShow as $coord)
                                    [{{ $coord[0] }}, {{ $coord[1] }}]@if(!$loop->last),<br>@endif
                                @endforeach
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
    <a href="{{ route('fitur.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('lokasi_sawit.create') }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus-circle"></i> Tambah Lokasi Sawit
    </a>
</div>

<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-1.547778, 103.092778], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Data area dengan polygon
    var areas = [
        // Polygon utama
        {
            name: "LAHAN SAWIT MANIS MADU",
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
        // Sub-polygon karyawan (dibagi urut dari polygon utama, proporsional luas)
        {
            name: "Rijal Nasution",
            areaSize: "L = 9.5 Ha",
            areaType: "Lahan Sawit",
            coords: [
                [-1.545000, 103.070000],
                [-1.542000, 103.075000],
                [-1.544000, 103.080000],
                [-1.548000, 103.082000],
                [-1.552000, 103.081000]
            ],
            center: [-1.546000, 103.076000],
            color: '#3498DB',
            strokeColor: '#2874A6',
            strokeWidth: 2,
            hasArea: true
        },
        {
            name: "Ade Saputra",
            areaSize: "L = 9.9 Ha",
            areaType: "Lahan Sawit",
            coords: [
                [-1.552000, 103.081000],
                [-1.557000, 103.080000],
                [-1.562000, 103.080000],
                [-1.567000, 103.081000],
                [-1.572000, 103.082000]
            ],
            center: [-1.560000, 103.081000],
            color: '#E74C3C',
            strokeColor: '#922B21',
            strokeWidth: 2,
            hasArea: true
        },
        {
            name: "Farhan",
            areaSize: "L = 10.8 Ha",
            areaType: "Lahan Sawit",
            coords: [
                [-1.572000, 103.082000],
                [-1.577000, 103.082000],
                [-1.582000, 103.081000],
                [-1.585000, 103.078000],
                [-1.586000, 103.074000]
            ],
            center: [-1.580000, 103.080000],
            color: '#F1C40F',
            strokeColor: '#B7950B',
            strokeWidth: 2,
            hasArea: true
        },
        {
            name: "Anwan",
            areaSize: "L = 9.7 Ha",
            areaType: "Lahan Sawit",
            coords: [
                [-1.586000, 103.074000],
                [-1.584000, 103.070000],
                [-1.580000, 103.068000],
                [-1.575000, 103.067000],
                [-1.570000, 103.068000],
                [-1.565000, 103.069000],
                [-1.560000, 103.070000],
                [-1.555000, 103.070000],
                [-1.550000, 103.070000],
                [-1.545000, 103.070000]
            ],
            center: [-1.570000, 103.070000],
            color: '#9B59B6',
            strokeColor: '#6C3483',
            strokeWidth: 2,
            hasArea: true
        }
    ];

    // Menambahkan polygon untuk setiap area
    areas.forEach(function(area) {
        // Debugging untuk melihat apakah data sudah diterima dengan benar
        console.log("Area: ", area.name, "Coords: ", area.coords, "Color: ", area.color);

        // Membuat polygon untuk area
        var polygon = L.polygon(area.coords, {
            color: area.strokeColor,  // Menggunakan warna garis luar dari database
            weight: area.strokeWidth, 
            fillOpacity: 0.5,
            fillColor: area.color  // Menggunakan warna isi dari database
        }).addTo(map);

        // Menambahkan popup pada polygon
        polygon.bindPopup(`
            <strong>${area.name}</strong><br>
            ${area.areaSize}
        `);

        // Menambahkan label pada tengah polygon
        var labelIcon = L.divIcon({
            className: 'area-label',
            html: `
                <div style="background: ${area.color}; color: white; padding: 5px; border-radius: 10px; text-align: center; font-weight: bold;">
                    ${area.name}
                </div>
            `,
            iconSize: [100, 40],
            iconAnchor: [50, 20]
        });

        L.marker(polygon.getBounds().getCenter(), { icon: labelIcon }).addTo(map);
    });

    // Toggle button untuk menampilkan/menyembunyikan tabel
    document.getElementById('toggleTableBtn').addEventListener('click', function() {
        const dataTable = document.getElementById('dataTable');
        const toggleText = document.getElementById('toggleText');
        const icon = this.querySelector('i');

        if (dataTable.style.display === 'none') {
            dataTable.style.display = 'block';
            toggleText.textContent = 'Sembunyikan Tabel';
            icon.className = 'fas fa-eye-slash';
        } else {
            dataTable.style.display = 'none';
            toggleText.textContent = 'Tampilkan Tabel';
            icon.className = 'fas fa-eye';
        }

        // Trigger map resize after DOM changes
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    });

</script>

@endsection
