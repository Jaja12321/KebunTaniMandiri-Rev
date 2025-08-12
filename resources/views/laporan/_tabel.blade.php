<div class="mb-4">
    <h5 class="font-weight-bold">📈 Pendapatan</h5>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nama</th>
                <th>Jumlah (Rp)</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pendapatan as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Data pendapatan tidak tersedia.</td>
                </tr>
            @endforelse
            <tr class="table-success">
                <td><strong>Total Pendapatan</strong></td>
                <td><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="mb-4">
    <h5 class="font-weight-bold">📉 Pengeluaran</h5>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nama</th>
                <th>Jumlah (Rp)</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengeluaran as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Data pengeluaran tidak tersedia.</td>
                </tr>
            @endforelse
            <tr class="table-danger">
                <td><strong>Total Pengeluaran</strong></td>
                <td><strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="mb-4">
    <h5 class="font-weight-bold">💰 Selisih (Laba / Rugi)</h5>
    <table class="table table-bordered">
        <tbody>
            <tr class="{{ $selisih >= 0 ? 'table-success' : 'table-danger' }}">
                <td><strong>Selisih</strong></td>
                <td><strong>Rp {{ number_format($selisih, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
