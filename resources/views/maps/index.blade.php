@extends('layouts.appmaps')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 600px;
        width: 100%;
    }
    .food-info {
        padding: 10px;
    }
    .food-info img {
        max-width: 200px;
        height: auto;
    }
</style>
@endsection

@section('content')
<div class="container pt-4 mt-4">
    <!-- <div class="text-center mb-10">
        <div class="col-md-12">
        <h2 class="text-3xl font-extrabold title-font gradient-text mb-2 animate-fade-up">
        Nearby Food Finder</h2>
        </div>
    </div> -->
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/3">
            <div class="bg-white/90 rounded-2xl shadow-lg p-4 max-h-[80vh] overflow-y-auto flex flex-col">
                <div class="mb-4 text-center">
                    <h5 class="text-2xl font-extrabold title-font gradient-text mb-2 animate-fade-up">
                        Makanan Terdekat
                    </h5>
                    <div class="relative flex items-center w-full">
                        <span class="absolute left-4 text-gray-400 text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                            </svg>
                        </span>
                        <input type="number" id="radius" min="1" max="100" onchange="loadNearbyFood()"
                            class="pl-12 pr-4 py-3 w-full rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none text-gray-700 placeholder-gray-400 shadow-sm transition text-base bg-white"
                            placeholder="Jarak maksimum (km)...">
                    </div>
                </div>
                <div id="nearby-food-list" class="flex flex-col gap-6"></div>
            </div>
        </div>
        <div class="w-full md:w-2/3">
            <div id="map" style="height:600px;width:100%"></div>
            <!-- <div class="form-group mt-3">
                <label for="radius">Jarak Maksimum (km):</label>
                <input type="number" id="radius" class="form-control" value="20" min="1" max="100" onchange="loadNearbyFood()">
            </div> -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    console.log('Leaflet:', typeof L, L);
    let map;
    let markers = [];
    let userMarker;
    let userLocation = null;

    // Initialize map
    document.addEventListener('DOMContentLoaded', function() {
        try {
            map = L.map('map').setView([-6.2088, 106.8456], 13); // Default to Jakarta
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
        } catch (e) {
            document.getElementById('map').innerHTML = '<div style="color:red">Gagal memuat peta. Pastikan koneksi internet dan script Leaflet aktif.</div>';
            return;
        }

        // Get user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                // Add user marker
                userMarker = L.marker([userLocation.lat, userLocation.lng])
                    .addTo(map)
                    .bindPopup('Lokasi Anda')
                    .openPopup();

                map.setView([userLocation.lat, userLocation.lng], 13);
                loadNearbyFood();
            });
        }

        // Load initial food markers
        const makanan = @json($makanan);
        makanan.forEach(food => {
            addFoodMarker(food);
        });
    });

    // Add food marker to map
    function addFoodMarker(food) {
        let statusColor = 'bg-green-100 text-green-700';
        let statusText = 'Tersedia';
        if (food.Status_Makanan === 'Segera Habis') {
            statusColor = 'bg-yellow-100 text-yellow-700';
            statusText = 'Segera Habis';
        } else if (food.Status_Makanan === 'Habis') {
            statusColor = 'bg-red-100 text-red-700';
            statusText = 'Habis';
        }
        const jarak = food.distance ? `${Math.round(food.distance * 100) / 100} km` : '-';
        const popupHtml = `
        <div style=\"max-width:320px; font-family:'Poppins',sans-serif;\">
            <div class=\"rounded-t-xl flex justify-end items-center p-2 ${statusColor}\" style=\"font-size:15px;font-weight:600; border-top-left-radius:1rem; border-top-right-radius:1rem;\">
                <span><i class='fas fa-check-circle mr-1'></i>${statusText}</span>
            </div>
            <div class=\"bg-orange-50 text-center py-2\" style=\"font-size:22px;font-weight:700;color:#ea580c;letter-spacing:0.5px;\">${food.Nama_Makanan}</div>
            <div class=\"flex flex-col gap-2 p-3\">
                <div class=\"bg-blue-50 rounded-xl px-3 py-2 mb-1\">
                    <span class=\"text-xs text-blue-600 font-bold uppercase flex items-center mb-1\"><i class=\"fas fa-tag mr-1 text-xs\"></i>Kategori</span>
                    <span class=\"text-base text-gray-800 font-medium\">${food.Kategori_Makanan || '-'}</span>
                </div>
                <div class="flex-1 min-w-[120px] bg-purple-50 rounded-xl p-2 text-xs ml-1 mb-2" style="display:inline-block;">
                    <div class="font-bold text-purple-500 mb-1" style="font-size:11px;"><i class='fas fa-boxes mr-1'></i>JUMLAH</div>
                    <div style="font-size:13px;">${food.Jumlah_Makanan || '-'} Porsi</div>
                </div>
                <div class=\"bg-red-50 rounded-xl px-3 py-2 mb-1\">
                    <span class=\"text-xs text-red-600 font-bold uppercase flex items-center mb-1\"><i class=\"fas fa-calendar-alt mr-1 text-xs\"></i>Kedaluwarsa</span>
                    <span class=\"text-base text-gray-800 font-medium\">${food.Tanggal_Kedaluwarsa ? getKedaluwarsaText(food.Tanggal_Kedaluwarsa) : '-'}</span>
                </div>
                <div class=\"bg-green-50 rounded-xl px-3 py-2 mb-1\">
                    <span class=\"text-xs text-green-600 font-bold uppercase flex items-center mb-1\"><i class=\"fas fa-map-marker-alt mr-1 text-xs\"></i>Lokasi</span>
                    <span class=\"text-base text-gray-800 font-medium\">${food.Lokasi_Makanan || '-'}</span>
                    <span class=\"text-xs text-gray-500 mt-1\"><i class=\"fas fa-route mr-1\"></i>Jarak: ${jarak}</span>
                </div>
            </div>
            <a href=\"/pengguna/food-listing/${food.ID_Makanan}\" class=\"block mt-3 py-2 w-full text-center rounded-xl font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition\" style=\"text-decoration:none;font-size:16px; border-radius:0.75rem;\">
                <i class=\"fas fa-eye mr-2\"></i>Lihat Detail
            </a>
        </div>
        `;
        const foodIcon = L.icon({
            iconUrl: '/marker-makanan.png',
            iconSize: [48, 48],
            iconAnchor: [24, 48],
            popupAnchor: [0, -48]
        });
        const marker = L.marker([food.latitude, food.longitude], { icon: foodIcon })
            .bindPopup(popupHtml, {
                autoPan: true,
                autoPanPadding: [30, 30],
                maxWidth: 320
            });
        markers.push(marker);
        marker.addTo(map);
    }

    // Helper untuk menghitung sisa hari kedaluwarsa
    function getKedaluwarsaText(tgl) {
        const now = new Date();
        const exp = new Date(tgl);
        const diff = Math.ceil((exp - now) / (1000 * 60 * 60 * 24));
        if (diff > 0) return diff + ' Hari lagi';
        if (diff === 0) return 'Hari ini';
        return 'Sudah Kedaluwarsa';
    }

    // Load nearby food
    function loadNearbyFood() {
        if (!userLocation) return;
        let radius = document.getElementById('radius').value;
        if (!radius) radius = 20;
        console.log('userLocation:', userLocation);
        fetch(`/pengguna/maps/nearby?latitude=${userLocation.lat}&longitude=${userLocation.lng}&radius=${radius}`)
            .then(response => response.json())
            .then(data => {
                // Clear existing markers
                markers.forEach(marker => map.removeLayer(marker));
                markers = [];

                // Add new markers
                data.forEach(food => {
                    addFoodMarker(food);
                });

                // Update nearby food list
                updateNearbyFoodList(data);
            })
            .catch(err => {
                alert('Gagal memuat data makanan terdekat.');
            });
    }

    // Update nearby food list
    function updateNearbyFoodList(foods) {
        const list = document.getElementById('nearby-food-list');
        list.innerHTML = '';
        if (foods.length === 0) {
            list.innerHTML = '<div class="text-center text-gray-500 py-4">Tidak ada makanan terdekat.</div>';
            return;
        }
        foods.forEach(food => {
            let statusColor = '';
            let statusText = food.Status_Makanan;
            if (food.Status_Makanan === 'Tersedia') {
                statusColor = 'bg-green-100 text-green-800';
            } else if (food.Status_Makanan === 'Segera Habis') {
                statusColor = 'bg-yellow-100 text-yellow-800';
            } else if (food.Status_Makanan === 'Habis') {
                statusColor = 'bg-red-100 text-red-800';
            } else {
                statusColor = 'bg-gray-100 text-gray-800';
            }
            const daysLeft = food.Tanggal_Kedaluwarsa ? getKedaluwarsaText(food.Tanggal_Kedaluwarsa) : '-';
            const jarak = food.distance ? `${Math.round(food.distance * 100) / 100} km` : '-';
            const card = document.createElement('div');
            card.className = 'rounded-xl shadow-md bg-white mb-6 p-0 overflow-hidden border border-gray-100 max-w-md mx-auto';
            card.innerHTML = `
                <div class="flex flex-col">
                    <div class="relative h-40 w-full overflow-hidden bg-gray-100 flex items-center justify-center rounded-t-xl">
                        <img src="${food.Foto_Makanan ? '/storage/' + food.Foto_Makanan : '/images/food-placeholder.jpg'}" alt="${food.Nama_Makanan}" class="w-full h-full object-cover ${food.Status_Makanan === 'Habis' ? 'opacity-60' : ''}">
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 ${statusColor} rounded-full text-xs font-medium shadow-sm">
                                ${statusText === 'Tersedia' ? '<i class=\'fas fa-check-circle mr-1\'></i>' : statusText === 'Segera Habis' ? '<i class=\'fas fa-clock mr-1\'></i>' : statusText === 'Habis' ? '<i class=\'fas fa-times-circle mr-1\'></i>' : '<i class=\'fas fa-info-circle mr-1\'></i>'}${statusText}
                            </span>
                        </div>
                    </div>
                    <div class="w-full bg-orange-50 px-4 py-3 text-center">
                        <h3 class="text-lg font-bold text-orange-700 leading-tight">${food.Nama_Makanan}</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-gray-700 px-4 pt-3 pb-1">
                        <div class="flex flex-col bg-blue-50 rounded-xl px-3 py-2 mb-2">
                            <span class="text-xs text-blue-600 font-bold uppercase mb-1 flex items-center"><i class="fas fa-tag mr-1 text-xs"></i>Kategori</span>
                            <span class="text-base text-gray-800 font-medium leading-snug">${food.Kategori_Makanan || '-'}</span>
                        </div>
                        <div class="flex flex-col bg-indigo-50 rounded-xl px-3 py-2 mb-2">
                            <span class="text-xs text-indigo-600 font-bold uppercase mb-1 flex items-center"><i class="fas fa-box mr-1 text-xs"></i>Jumlah Tersedia</span>
                            <span class="text-base text-gray-800 font-medium leading-snug">${food.Jumlah_Makanan || '-'} Porsi</span>
                        </div>
                        <div class="flex flex-col bg-red-50 rounded-xl px-3 py-2 mb-2">
                            <span class="text-xs text-red-600 font-bold uppercase mb-1 flex items-center"><i class="fas fa-calendar-alt mr-1 text-xs"></i>Kedaluwarsa</span>
                            <span class="text-base text-gray-800 font-medium leading-snug">${daysLeft}</span>
                        </div>
                        <div class="flex flex-col bg-green-50 rounded-xl px-3 py-2 mb-2">
                            <span class="text-xs text-green-600 font-bold uppercase mb-1 flex items-center"><i class="fas fa-map-marker-alt mr-1 text-xs"></i>Lokasi</span>
                            <span class="text-base text-gray-800 font-medium leading-snug">${food.Lokasi_Makanan || '-'}</span>
                            <span class="text-xs text-gray-500 mt-1"><i class="fas fa-route mr-1"></i>Jarak: ${jarak}</span>
                        </div>
                    </div>
                    <div class="px-4 pb-4 pt-2">
                        <a href="/pengguna/food-listing/${food.ID_Makanan}" class="inline-block w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-2 rounded-xl font-semibold text-center transition animate-scale shadow-md mt-2" style="text-decoration:none;font-size:16px;">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            `;
            list.appendChild(card);
        });
    }
</script>
@endsection 