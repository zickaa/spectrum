@extends('layouts.app')

@section('title', 'Riwayat')

@section('content')
<div class="container py-4">
    <h4 class="mb-3"><i class="fas fa-history"></i> Riwayat Monitoring Hidroponik</h4>

    {{-- Tampilkan notifikasi sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form tombol hapus semua data --}}
    <form method="POST" action="{{ route('history.deleteAll') }}" onsubmit="return confirm('Yakin ingin menghapus semua data riwayat?');" class="mb-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash-alt"></i> Hapus Semua Data Riwayat
        </button>
    </form>

    <div class="card card-custom mb-4">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Nutrisi (PPM)</th>
                        <th>Status Nutrisi</th>
                        <th>Pompa Nutrisi</th>
                        <th>Jarak Air (cm)</th>
                        <th>Status Air</th>
                        <th>Pompa Air</th>
                        <th>Pompa Aliran</th>
                        <th>Dinamo Pengaduk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tdsData as $index => $tds)
                        @php
                            // Cari ultrasonic dengan waktu yang sama (atau paling mendekati)
                            $ultra = $ultrasonicData->firstWhere('created_at', $tds->created_at);
                            // Dinamo mengikuti status pompa nutrisi
                            $dinamoStatus = $tds->pompa_nutrisi ? 'ON' : 'OFF';
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tds->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $tds->nutrisi_ppm }}</td>
                            <td>{{ $tds->status_nutrisi }}</td>
                            <td>{{ $tds->pompa_nutrisi ? 'ON' : 'OFF' }}</td>
                            <td>{{ $ultra->jarak_air ?? '-' }}</td>
                            <td>{{ $ultra->status_air ?? '-' }}</td>
                            <td>{{ isset($ultra) ? ($ultra->pompa_air ? 'ON' : 'OFF') : '-' }}</td>
                            <td>{{ $tds->pompa_aliran ? 'ON' : 'OFF' }}</td>
                            <td>{{ $dinamoStatus }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="10">Tidak ada data riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
