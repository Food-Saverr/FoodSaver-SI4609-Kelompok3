@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-center text-2xl font-bold text-orange-600 mb-6">Riwayat Permintaan</h2>

    <table class="min-w-full bg-white border border-orange-500 rounded-lg overflow-hidden">
        <thead class="bg-orange-100">
            <tr class="text-left text-orange-600 font-semibold">
                <th class="px-4 py-3 border-r border-orange-500">Nama Makanan</th>
                <th class="px-4 py-3 border-r border-orange-500">Kedaluwarsa</th>
                <th class="px-4 py-3 border-r border-orange-500">Lokasi</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permintaans as $permintaan)
                <tr class="border-t border-orange-500">
                    <td class="px-4 py-3">{{ $permintaan->makanan->Nama_Makanan }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($permintaan->makanan->Tanggal_Kedaluwarsa)->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">{{ $permintaan->makanan->Lokasi_Makanan }}</td>
                    <td class="px-4 py-3">
                        @php
                            $status = $permintaan->Status_Permintaan;
                            $warna = $status == 'Disetujui' ? 'green' : ($status == 'Ditolak' ? 'red' : 'yellow');
                        @endphp
                        <span class="bg-{{ $warna }}-500 text-white text-sm px-3 py-1 rounded-full">
                            {{ $status == 'Disetujui' ? 'Diterima' : ($status == 'Ditolak' ? 'Ditolak' : 'Menunggu') }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
