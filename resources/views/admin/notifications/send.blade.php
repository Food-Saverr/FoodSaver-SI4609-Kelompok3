@extends('layouts.appadmin')
@section('content')
<div class="max-w-xl mx-auto mt-24 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Kirim Notifikasi</h2>
    <form method="POST" action="{{ route('admin.notifications.send') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-1">Target</label>
            <select name="target" class="w-full border rounded p-2" required onchange="toggleUserSelect(this.value)">
                <option value="all_donatur">Semua Donatur</option>
                <option value="all_pengguna">Semua Penerima Makanan</option>
                <option value="all">Semua Pengguna & Donatur</option>
                <option value="single">User Tertentu</option>
            </select>
        </div>
        <div class="mb-4" id="user-select" style="display:none;">
            <label class="block font-semibold mb-1">Pilih User</label>
            <select name="user_id" class="w-full border rounded p-2">
                <optgroup label="Donatur">
                    @foreach($donaturs as $d)
                        <option value="{{ $d->ID_Pengguna }}">{{ $d->Nama_Pengguna }} (Donatur)</option>
                    @endforeach
                </optgroup>
                <optgroup label="Penerima Makanan">
                    @foreach($penggunas as $p)
                        <option value="{{ $p->ID_Pengguna }}">{{ $p->Nama_Pengguna }} (Pengguna)</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Tipe Notifikasi</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="maintenance">Maintenance</option>
                <option value="announcement">Pengumuman</option>
                <option value="advertisement">Iklan</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" class="w-full border rounded p-2" required maxlength="100">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pesan</label>
            <textarea name="message" class="w-full border rounded p-2" required maxlength="255"></textarea>
        </div>
        <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Kirim</button>
    </form>
</div>
<script>
function toggleUserSelect(val) {
    document.getElementById('user-select').style.display = (val === 'single') ? '' : 'none';
}
</script>
@endsection 