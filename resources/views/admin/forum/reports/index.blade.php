@extends('layouts.appadmin')

@section('title', 'Kelola Laporan Forum')

@section('content')
<!-- Page Header with Dynamic Gradient -->
<div class="relative min-h-[400px] flex items-center overflow-hidden bg-gradient-to-r from-red-700 to-red-600 shadow-xl">
    <!-- Decorative Patterns with reduced opacity -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white"></div>
        <div class="absolute right-20 top-20 w-16 h-16 rounded-full bg-white"></div>
        <div class="absolute left-20 bottom-5 w-24 h-24 rounded-full bg-white"></div>
    </div>
    
    <!-- Semi-transparent overlay for better text contrast -->
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    
    <div class="container mx-auto px-4 sm:px-6 py-10 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="text-white">
                <h1 class="mt-14 text-3xl font-bold flex items-center text-shadow">
                    <div class="p-2 bg-white bg-opacity-20 backdrop-blur-sm rounded-lg mr-3">
                        <i class="fas fa-flag text-white"></i>
                    </div>
                    Kelola Laporan Forum
                </h1>
                <p class="mt-2 text-white max-w-xl font-medium text-shadow-sm bg-black bg-opacity-10 inline-block px-3 py-1 rounded-lg">
                    Tinjau dan tangani laporan dari pengguna terkait konten forum yang tidak pantas
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.forum.index') }}" class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-md text-red-700 hover:bg-red-50 transition-colors duration-200 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Forum
                </a>
            </div>
        </div>
    </div>
    
    <!-- Wave Pattern with adjusted opacity -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="fill-white">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>

<!-- Page Content -->
<div class="bg-gray-50 min-h-screen pb-12 mt-20">
    <div class="container mx-auto px-4 sm:px-6 -mt-6">
        <!-- Stats Dashboard -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Reports -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-flag text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Laporan</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalReports) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-blue-500 to-blue-600"></div>
            </div>
            
            <!-- Pending Reports -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Menunggu Tindakan</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($pendingReports) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
            </div>
            
            <!-- Actioned Reports -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Ditindaklanjuti</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($actionedReports) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-green-500 to-green-600"></div>
            </div>
            
            <!-- Rejected Reports -->
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transform transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="p-6 flex items-center">
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-xl group-hover:scale-105 transition-transform mr-5">
                        <i class="fas fa-ban text-red-600 text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xs uppercase tracking-wider text-gray-500 font-medium">Ditolak</div>
                        <div class="mt-1 flex items-center">
                            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($rejectedReports) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="h-1 w-full bg-gradient-to-r from-red-500 to-red-600"></div>
            </div>
        </div>
        
        <!-- Filter & Search Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="p-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-filter text-red-600 mr-2"></i> Filter & Pencarian
                </h5>
                <form action="{{ route('admin.forum.reports') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Search Input -->
                        <div class="md:col-span-4">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Kata Kunci</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" class="h-11 block w-full pl-10 pr-3 py-2 sm:text-sm rounded-xl border-gray-300 bg-gray-50 focus:ring-red-500 focus:border-red-500" 
                                    placeholder="Cari berdasarkan judul atau pelapor..." 
                                    value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="md:col-span-3">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="h-11 block w-full py-2 px-3 rounded-xl border-gray-300 bg-gray-50 focus:ring-red-500 focus:border-red-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Tindakan</option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Sudah Ditinjau</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="actioned" {{ request('status') == 'actioned' ? 'selected' : '' }}>Ditindaklanjuti</option>
                            </select>
                        </div>
                        
                        <!-- Reason Filter -->
                        <div class="md:col-span-3">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                            <select name="reason" id="reason" class="h-11 block w-full py-2 px-3 rounded-xl border-gray-300 bg-gray-50 focus:ring-red-500 focus:border-red-500">
                                <option value="">Semua Alasan</option>
                                <option value="spam" {{ request('reason') == 'spam' ? 'selected' : '' }}>Spam atau Promosi</option>
                                <option value="inappropriate" {{ request('reason') == 'inappropriate' ? 'selected' : '' }}>Konten Tidak Pantas</option>
                                <option value="harassment" {{ request('reason') == 'harassment' ? 'selected' : '' }}>Pelecehan/Intimidasi</option>
                                <option value="violence" {{ request('reason') == 'violence' ? 'selected' : '' }}>Konten Kekerasan</option>
                                <option value="hate_speech" {{ request('reason') == 'hate_speech' ? 'selected' : '' }}>Ujaran Kebencian</option>
                                <option value="false_info" {{ request('reason') == 'false_info' ? 'selected' : '' }}>Informasi Palsu</option>
                                <option value="other" {{ request('reason') == 'other' ? 'selected' : '' }}>Alasan Lain</option>
                            </select>
                        </div>
                        
                        <!-- Sort & Submit -->
                        <div class="md:col-span-2">
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <div class="flex space-x-2">
                                <select name="sort" id="sort" class="h-11 block w-full py-2 px-3 rounded-xl border-gray-300 bg-gray-50 focus:ring-red-500 focus:border-red-500">
                                    <option value="latest" {{ (request('sort') == 'latest' || !request('sort')) ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                </select>
                                
                                <button type="submit" class="h-11 w-11 flex items-center justify-center bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-filter"></i>
                                </button>
                                
                                <a href="{{ route('admin.forum.reports') }}" class="h-11 w-11 flex items-center justify-center border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Reports List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-flag text-red-600 mr-3 text-lg"></i>
                    <h5 class="font-bold text-gray-800 text-lg">Daftar Laporan</h5>
                    <span class="ml-3 px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                        {{ $reports->total() }} Laporan
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="button" class="text-gray-500 hover:text-red-600">
                        <i class="fas fa-download"></i>
                    </button>
                    <div class="h-4 w-px bg-gray-300"></div>
                    <button type="button" class="text-gray-500 hover:text-red-600">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
            
            <div>
                @if($reports->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16">
                        <div class="bg-red-50 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-300" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Tidak Ada Laporan</h3>
                        <p class="text-gray-500 mt-2 max-w-sm text-center">Tidak ditemukan laporan yang sesuai dengan filter yang dipilih</p>
                        <button type="button" class="mt-4 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors font-medium">
                            Reset Filter
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600 font-semibold">
                                    <th class="px-6 py-3 text-left">ID</th>
                                    <th class="px-6 py-3 text-left">Postingan</th>
                                    <th class="px-6 py-3 text-left">Pelapor</th>
                                    <th class="px-6 py-3 text-left">Alasan</th>
                                    <th class="px-6 py-3 text-center">Status</th>
                                    <th class="px-6 py-3 text-left">Tanggal Laporan</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        #{{ $report->ID_Report }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.forum.show', $report->ID_ForumPost) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            {{ Str::limit($report->post->judul ?? '[Postingan Dihapus]', 40) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="{{ $report->reporter->foto ? asset('storage/'.$report->reporter->foto) : 'https://ui-avatars.com/api/?name='.urlencode($report->reporter->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                                 class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm" 
                                                 alt="{{ $report->reporter->Nama_Pengguna }}">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-800">{{ $report->reporter->Nama_Pengguna }}</div>
                                                <div class="flex items-center mt-0.5">
                                                    <span class="px-1.5 py-0.5 text-xs rounded-md {{ 
                                                        $report->reporter->Role_Pengguna == 'Admin' ? 'bg-red-100 text-red-800' : 
                                                        ($report->reporter->Role_Pengguna == 'Donatur' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') 
                                                    }}">
                                                        {{ $report->reporter->Role_Pengguna }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium
                                            {{ $report->alasan_laporan == 'spam' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $report->alasan_laporan == 'inappropriate' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $report->alasan_laporan == 'harassment' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $report->alasan_laporan == 'violence' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $report->alasan_laporan == 'hate_speech' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $report->alasan_laporan == 'false_info' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $report->alasan_laporan == 'other' ? 'bg-gray-100 text-gray-800' : '' }}
                                        ">
                                            {{ $report->getReasonLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1.5 rounded-full text-xs font-medium
                                            {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $report->status == 'reviewed' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $report->status == 'rejected' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $report->status == 'actioned' ? 'bg-green-100 text-green-800' : '' }}
                                        ">
                                            @if($report->status == 'pending')
                                                <i class="fas fa-clock mr-1"></i> Menunggu
                                            @elseif($report->status == 'reviewed')
                                                <i class="fas fa-eye mr-1"></i> Ditinjau
                                            @elseif($report->status == 'rejected')
                                                <i class="fas fa-times-circle mr-1"></i> Ditolak
                                            @elseif($report->status == 'actioned')
                                                <i class="fas fa-check-circle mr-1"></i> Ditindaklanjuti
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $report->created_at->format('d M Y, H:i') }}
                                        <div class="text-xs">{{ $report->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.forum.reports.show', $report->ID_Report) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                                <i class="fas fa-eye mr-1"></i> Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection