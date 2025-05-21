{{-- resources/views/admin/ExpiredReminder/index.blade.php --}}
@extends('layouts.appadmin')

@section('title', 'Pengingat Makanan Kedaluwarsa - FoodSaver')

@section('content')
<!-- Main Container -->
<div class="container mx-auto px-4 py-8" style="margin-top: 100px;">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="p-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold title-font gradient-text mb-2">Pengingat Makanan Kedaluwarsa</h1>
                <p class="text-gray-600">Kelola daftar makanan yang mendekati tanggal kedaluwarsa dan kirim pengingat kepada donatur.</p>
            </div>
            <div class="bg-primary-500 text-white rounded-full p-4 flex items-center justify-center">
                <i class="fas fa-bell text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Hampir Kedaluwarsa Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border-l-4 border-yellow-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-yellow-500 uppercase mb-1">Hampir Kedaluwarsa</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $makanans->where(function($query) { 
                                $date = \Carbon\Carbon::now()->addDays(3);
                                return $query->where('Tanggal_Kedaluwarsa', '<=', $date);
                            })->count() }}</div>
                    </div>
                    <div class="bg-yellow-100 text-yellow-500 rounded-full p-3 flex items-center justify-center">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kadaluwarsa Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border-l-4 border-red-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-red-500 uppercase mb-1">Kedaluwarsa</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $makanans->where(function($query) { 
                                $date = \Carbon\Carbon::now();
                                return $query->where('Tanggal_Kedaluwarsa', '<', $date);
                            })->count() }}</div>
                    </div>
                    <div class="bg-red-100 text-red-500 rounded-full p-3 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Telah Diberitahu Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border-l-4 border-green-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-green-500 uppercase mb-1">Telah Diberitahu</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $makanans->where('notified', true)->count() }}</div>
                    </div>
                    <div class="bg-green-100 text-green-500 rounded-full p-3 flex items-center justify-center">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buat Pengingat Baru Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border-l-4 border-blue-500 hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-blue-500 uppercase mb-1">Buat Pengingat Baru</div>
                        <div class="mt-3">
                            <a href="{{ route('admin.expired-reminders.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center w-full justify-center">
                                <i class="fas fa-bell mr-2"></i> Kirim Pemberitahuan
                            </a>
                        </div>
                    </div>
                    <div class="bg-blue-100 text-blue-500 rounded-full p-3 flex items-center justify-center">
                        <i class="fas fa-paper-plane text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md">
        <div class="flex items-center">
            <div class="mr-3">
                <i class="fas fa-check-circle text-2xl text-green-500"></i>
            </div>
            <div>
                <h6 class="font-bold mb-1">Berhasil!</h6>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="ml-auto text-green-500 hover:text-green-700" onclick="this.parentElement.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Main Content Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <!-- Card Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <div class="flex items-center">
                <div class="bg-blue-500 text-white rounded-full p-2 mr-3 flex items-center justify-center">
                    <i class="fas fa-list-alt"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-700">Daftar Makanan Yang Akan Kedaluwarsa</h2>
            </div>
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md flex items-center text-sm">
                    <i class="fas fa-cog mr-2"></i> Aksi
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10" style="display: none;">
                    <div class="py-2 px-3 text-xs text-gray-600 border-b border-gray-100">Opsi Pemberitahuan:</div>
                    <a href="{{ route('ExpiredReminder.send') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-500 hover:text-white">
                        <i class="fas fa-bell mr-2 text-blue-500"></i> Kirim Semua Pengingat
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <a href="{{ route('admin.expired-reminders.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-500 hover:text-white">
                        <i class="fas fa-plus-circle mr-2 text-green-500"></i> Buat Pemberitahuan Baru
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Card Body -->
        <div class="p-6">
            <!-- Filter Row -->
            <div class="flex flex-col md:flex-row justify-between mb-4">
                <div class="mb-3 md:mb-0">
                    <div class="flex flex-wrap">
                        <button type="button" class="bg-blue-500 text-white rounded-md px-3 py-1 mr-2 mb-2 filter-btn text-sm" data-filter="all">
                            <i class="fas fa-th-list mr-1"></i> Semua
                        </button>
                        <button type="button" class="bg-white hover:bg-red-500 hover:text-white text-red-500 border border-red-500 rounded-md px-3 py-1 mr-2 mb-2 filter-btn text-sm" data-filter="expired">
                            <i class="fas fa-exclamation-circle mr-1"></i> Kedaluwarsa
                        </button>
                        <button type="button" class="bg-white hover:bg-yellow-500 hover:text-white text-yellow-500 border border-yellow-500 rounded-md px-3 py-1 mr-2 mb-2 filter-btn text-sm" data-filter="critical">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Kritis
                        </button>
                        <button type="button" class="bg-white hover:bg-blue-400 hover:text-white text-blue-400 border border-blue-400 rounded-md px-3 py-1 mr-2 mb-2 filter-btn text-sm" data-filter="warning">
                            <i class="fas fa-clock mr-1"></i> Peringatan
                        </button>
                        <button type="button" class="bg-white hover:bg-green-500 hover:text-white text-green-500 border border-green-500 rounded-md px-3 py-1 mb-2 filter-btn text-sm" data-filter="notified">
                            <i class="fas fa-bell mr-1"></i> Telah Diberitahu
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <div class="flex items-center border border-gray-300 rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500">
                        <div class="bg-blue-500 text-white px-2 py-1">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" id="searchInput" placeholder="Cari makanan..." class="block w-full px-3 py-1 focus:outline-none text-sm">
                        <div id="clearSearch" class="px-2 py-1 text-gray-500 hover:text-gray-700 cursor-pointer">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto rounded-md shadow-sm">
                <table class="min-w-full divide-y divide-gray-200" id="dataTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-utensils text-blue-500 mr-2"></i> Nama Makanan
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-user text-green-500 mr-2"></i> Donatur
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i> Tanggal Kedaluwarsa
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-yellow-500 mr-2"></i> Status
                                </div>
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-bell text-red-500 mr-2"></i> Notifikasi
                                </div>
                            </th>
                            <th class="px-4 py-2 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-cogs text-gray-500 mr-2"></i> Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($makanans as $makanan)
                            @php
                                // Menghitung sisa hari dengan lebih akurat (sesuai tanggal kalender)
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $expiryDate = \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->startOfDay();
                                $isExpired = $today->gt($expiryDate);
                                $daysLeft = $isExpired ? 0 : $today->diffInDays($expiryDate);
                                $rowClass = $isExpired ? 'bg-red-50' : ($daysLeft <= 1 ? 'bg-yellow-50' : ($daysLeft <= 3 ? 'bg-blue-50' : ''));
                            @endphp
                            <tr class="{{ $rowClass }} hover:bg-gray-50 transition duration-150 data-row" 
                                data-expired="{{ $isExpired ? 'true' : 'false' }}" 
                                data-critical="{{ $daysLeft <= 1 ? 'true' : 'false' }}" 
                                data-warning="{{ $daysLeft <= 3 ? 'true' : 'false' }}"
                                data-notified="{{ $makanan->notified ? 'true' : 'false' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $makanan->Nama_Makanan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-gray-100 rounded-full p-2 mr-2 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-500"></i>
                                        </div>
                                        <span>{{ $makanan->donatur->Nama_Pengguna ?? 'Tidak Diketahui' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="far fa-calendar-alt mr-2 text-gray-500"></i>
                                        {{ \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($isExpired)
                                        <span class="px-3 py-1 inline-flex items-center bg-red-100 text-red-800 rounded-md text-sm font-medium">
                                            <i class="fas fa-exclamation-circle mr-2"></i> Sudah Kedaluwarsa
                                        </span>
                                    @elseif($daysLeft == 0)
                                        <span class="px-3 py-1 inline-flex items-center bg-red-100 text-red-800 rounded-md text-sm font-medium">
                                            <i class="fas fa-exclamation-circle mr-2"></i> Hari Ini
                                        </span>
                                    @elseif($daysLeft == 1)
                                        <span class="px-3 py-1 inline-flex items-center bg-yellow-100 text-yellow-800 rounded-md text-sm font-medium">
                                            <i class="fas fa-exclamation-triangle mr-2"></i> Besok
                                        </span>
                                    @elseif($daysLeft <= 3)
                                        <span class="px-3 py-1 inline-flex items-center bg-blue-100 text-blue-800 rounded-md text-sm font-medium">
                                            <i class="fas fa-clock mr-2"></i> {{ $daysLeft }} Hari Lagi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex items-center bg-gray-100 text-gray-800 rounded-md text-sm font-medium">
                                            <i class="fas fa-check-circle mr-2"></i> {{ $daysLeft }} Hari Lagi
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($makanan->notified)
                                        <span class="px-3 py-1 inline-flex items-center bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                            <i class="fas fa-bell mr-1"></i> Diberitahu
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex items-center bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                            <i class="fas fa-bell-slash mr-1"></i> Belum
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('admin.expired-reminders.show', $makanan->ID_Makanan) }}" 
                                            class="bg-blue-500 text-white rounded-full p-2 mr-2 hover:bg-blue-600 transition duration-150 tooltip-trigger"
                                            data-tooltip="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$makanan->notified)
                                        <form action="{{ route('admin.expired-reminders.notify', $makanan->ID_Makanan) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-yellow-500 text-white rounded-full p-2 hover:bg-yellow-600 transition duration-150 tooltip-trigger"
                                                    data-tooltip="Kirim Notifikasi">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="bg-gray-300 text-white rounded-full p-2 cursor-not-allowed tooltip-trigger"
                                                data-tooltip="Sudah Diberitahu">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="bg-gray-50 rounded-xl py-8">
                                        <div class="bg-green-100 text-green-600 rounded-full p-4 mx-auto mb-4 w-20 h-20 flex items-center justify-center animate-pulse-slow">
                                            <i class="fas fa-check-circle text-4xl"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">Semua Makanan Aman!</h3>
                                        <p class="text-gray-600 mb-4 max-w-lg mx-auto">Tidak ada makanan yang perlu diperhatikan saat ini. Semua makanan dalam kondisi baik dan jauh dari tanggal kedaluwarsa.</p>
                                        <a href="{{ route('admin.expired-reminders.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-medium px-5 py-2 rounded-lg transition duration-150">
                                            <i class="fas fa-bell mr-2"></i> Buat Pemberitahuan Manual
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-pulse-slow {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7);
        }
        50% {
            opacity: 0.9;
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(74, 222, 128, 0);
        }
    }
    
    /* Tooltip styles */
    .tooltip-trigger {
        position: relative;
    }
    .tooltip-trigger:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        white-space: nowrap;
        margin-bottom: 0.5rem;
        z-index: 10;
    }
    
    /* Filter button active state */
    .filter-btn.active {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const dataRows = document.querySelectorAll('.data-row');
        const searchInput = document.getElementById('searchInput');
        const clearSearch = document.getElementById('clearSearch');
        
        // Set initial active state
        document.querySelector('[data-filter="all"]').classList.add('active');
        
        // Add click event to filter buttons
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn !== this) {
                        btn.classList.add('bg-white');
                        btn.classList.remove('text-white');
                    }
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                if (this.getAttribute('data-filter') !== 'all') {
                    this.classList.remove('bg-white');
                    this.classList.add('text-white');
                }
                
                const filterValue = this.getAttribute('data-filter');
                
                // Filter table rows with animation
                dataRows.forEach(row => {
                    row.style.transition = 'opacity 300ms';
                    
                    if (filterValue === 'all') {
                        row.style.display = '';
                        setTimeout(() => { row.style.opacity = 1; }, 50);
                    } else if (filterValue === 'expired' && row.getAttribute('data-expired') === 'true') {
                        row.style.display = '';
                        setTimeout(() => { row.style.opacity = 1; }, 50);
                    } else if (filterValue === 'critical' && row.getAttribute('data-critical') === 'true') {
                        row.style.display = '';
                        setTimeout(() => { row.style.opacity = 1; }, 50);
                    } else if (filterValue === 'warning' && row.getAttribute('data-warning') === 'true') {
                        row.style.display = '';
                        setTimeout(() => { row.style.opacity = 1; }, 50);
                    } else if (filterValue === 'notified' && row.getAttribute('data-notified') === 'true') {
                        row.style.display = '';
                        setTimeout(() => { row.style.opacity = 1; }, 50);
                    } else {
                        row.style.opacity = 0;
                        setTimeout(() => { row.style.display = 'none'; }, 300);
                    }
                });
            });
        });
        
        // Search functionality
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                
                dataRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.transition = 'opacity 300ms';
                    
                    if (text.includes(searchValue)) {
                        row.style.display = '';
                        setTimeout(() => { row.style.opacity = 1; }, 50);
                    } else {
                        row.style.opacity = 0;
                        setTimeout(() => { row.style.display = 'none'; }, 300);
                    }
                });
            });
            
            // Clear search
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.focus();
            });
        }
    });
</script>
@endpush
@endsection
