@extends('layouts.appadmin')

@section('title', 'Detail Laporan Forum')

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
                    Detail Laporan #{{ $report->ID_Report }}
                </h1>
                <div class="mt-2 text-white flex items-center flex-wrap gap-3">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span>Pelapor: {{ $report->reporter->Nama_Pengguna }}</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ $report->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center">
                        <i class="fas fa-tag mr-2"></i>
                        <span>{{ $report->getReasonLabel() }}</span>
                    </div>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.forum.reports') }}" class="inline-flex items-center px-4 py-2 bg-white rounded-lg shadow-md text-red-700 hover:bg-red-50 transition-colors duration-200 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
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
<div class="bg-gray-50 min-h-screen pb-12">
    <div class="container mx-auto px-4 sm:px-6 -mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Report Details -->
                <div class="mt-16 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                            Laporan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 mb-2">Alasan Laporan</h4>
                            <p class="text-lg font-medium text-gray-900 bg-gray-50 p-3 rounded-xl border border-gray-200">
                                {{ $report->getReasonLabel() }}
                            </p>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 mb-2">Deskripsi Laporan</h4>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 prose max-w-none">
                                @if($report->deskripsi)
                                    <p>{{ $report->deskripsi }}</p>
                                @else
                                    <p class="text-gray-400 italic">Tidak ada deskripsi yang diberikan oleh pelapor.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Post Content -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                            Konten Yang Dilaporkan
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($report->post)
                            <div class="flex items-start mb-6">
                                <div class="flex-shrink-0">
                                    <img src="{{ $report->post->pengguna->foto ? asset('storage/'.$report->post->pengguna->foto) : 'https://ui-avatars.com/api/?name='.urlencode($report->post->pengguna->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                        class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" 
                                        alt="{{ $report->post->pengguna->Nama_Pengguna }}">
                                </div>
                                <div class="ml-4 flex-grow">
                                    <a href="{{ route('admin.forum.show', $report->post->ID_ForumPost) }}" target="_blank" class="text-xl font-bold text-blue-600 hover:text-blue-800 flex items-center">
                                        {{ $report->post->judul }}
                                        <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                                    </a>
                                    <div class="flex items-center mt-1 text-sm text-gray-500">
                                        <span>Oleh <span class="font-medium">{{ $report->post->pengguna->Nama_Pengguna }}</span></span>
                                        <span class="mx-2">&bull;</span>
                                        <span>{{ $report->post->created_at->format('d M Y, H:i') }}</span>
                                        <span class="mx-2">&bull;</span>
                                        <span>{{ $report->post->comments->count() }} Komentar</span>
                                        <span class="mx-2">&bull;</span>
                                        <span>{{ $report->post->likes()->count() }} Suka</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-4">
                                <div class="prose max-w-none">
                                    {!! $report->post->konten !!}
                                </div>
                            </div>
                            
                            <!-- If post has attachments -->
                            @if($report->post->attachments->isNotEmpty())
                                <div class="mt-6 border-t border-gray-200 pt-4">
                                    <h4 class="font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        Lampiran ({{ $report->post->attachments->count() }})
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($report->post->attachments as $attachment)
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm hover:bg-gray-100 transition-colors">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="font-medium text-gray-700 truncate">{{ $attachment->nama_file }}</div>
                                                    <a href="{{ route('admin.forum.attachment.download', $attachment->ID_Attachment) }}" class="text-blue-600 hover:text-blue-800">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ number_format($attachment->ukuran / 1024, 0) }} KB</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex items-center justify-center p-8 bg-red-50 rounded-xl">
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                                        <i class="fas fa-trash-alt text-red-500 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-red-800 mb-2">Postingan Telah Dihapus</h3>
                                    <p class="text-red-700">Postingan yang dilaporkan sudah tidak tersedia lagi karena telah dihapus.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Other Reports -->
                @if($otherReports->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-orange-50 to-orange-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="fas fa-flag text-orange-600 mr-2"></i>
                            Laporan Lain Untuk Postingan Ini
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($otherReports->isEmpty())
                            <div class="text-center py-6">
                                <p class="text-gray-500">Tidak ada laporan lain untuk postingan ini.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($otherReports as $otherReport)
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <img src="{{ $otherReport->reporter->foto ? asset('storage/'.$otherReport->reporter->foto) : 'https://ui-avatars.com/api/?name='.urlencode($otherReport->reporter->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                                     class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm" 
                                                     alt="{{ $otherReport->reporter->Nama_Pengguna }}">
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-800">{{ $otherReport->reporter->Nama_Pengguna }}</div>
                                                    <div class="text-xs text-gray-500">{{ $otherReport->created_at->format('d M Y, H:i') }}</div>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                {{ $otherReport->alasan_laporan == 'spam' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $otherReport->alasan_laporan == 'inappropriate' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $otherReport->alasan_laporan == 'harassment' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $otherReport->alasan_laporan == 'violence' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $otherReport->alasan_laporan == 'hate_speech' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $otherReport->alasan_laporan == 'false_info' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $otherReport->alasan_laporan == 'other' ? 'bg-gray-100 text-gray-800' : '' }}
                                            ">
                                                {{ $otherReport->getReasonLabel() }}
                                            </span>
                                        </div>
                                        @if($otherReport->deskripsi)
                                            <div class="mt-2 text-sm text-gray-600">
                                                {{ $otherReport->deskripsi }}
                                            </div>
                                        @endif
                                        <div class="mt-3 flex justify-end">
                                            <a href="{{ route('admin.forum.reports.show', $otherReport->ID_Report) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-xs font-medium">
                                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-15">
                <!-- Action Card -->
                <div class="mt-16 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-green-50 to-green-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="fas fa-tasks text-green-600 mr-2"></i>
                            Tindakan
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.forum.reports.update', $report->ID_Report) }}" method="POST">
                            @csrf
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" name="status" id="status_pending" value="pending" {{ $report->status == 'pending' ? 'checked' : '' }} class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                            <label for="status_pending" class="ml-2 block text-sm text-gray-700">Menunggu</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="status" id="status_reviewed" value="reviewed" {{ $report->status == 'reviewed' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="status_reviewed" class="ml-2 block text-sm text-gray-700">Sudah Ditinjau</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="status" id="status_rejected" value="rejected" {{ $report->status == 'rejected' ? 'checked' : '' }} class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                                            <label for="status_rejected" class="ml-2 block text-sm text-gray-700">Ditolak</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="status" id="status_actioned" value="actioned" {{ $report->status == 'actioned' ? 'checked' : '' }} class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                            <label for="status_actioned" class="ml-2 block text-sm text-gray-700">Ditindaklanjuti</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan</label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" name="action" id="action_none" value="none" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="action_none" class="ml-2 block text-sm text-gray-700">Tidak Ada Tindakan</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" name="action" id="action_delete_post" value="delete_post" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                            <label for="action_delete_post" class="ml-2 block text-sm text-gray-700">Hapus Postingan</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                                    <textarea id="admin_notes" name="admin_notes" rows="4" class="shadow-sm block w-full focus:ring-green-500 focus:border-green-500 sm:text-sm border-gray-300 rounded-md" placeholder="Tambahkan catatan terkait penanganan laporan...">{{ $report->admin_notes }}</textarea>
                                </div>
                                
                                <div class="flex justify-between">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Reporter Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                            Info Pelapor
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col items-center text-center mb-4">
                            <img src="{{ $report->reporter->foto ? asset('storage/'.$report->reporter->foto) : 'https://ui-avatars.com/api/?name='.urlencode($report->reporter->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                class="w-20 h-20 rounded-full object-cover border-2 border-white shadow-lg" 
                                alt="{{ $report->reporter->Nama_Pengguna }}">
                            <h4 class="mt-3 font-semibold text-lg">{{ $report->reporter->Nama_Pengguna }}</h4>
                            <span class="px-2 py-1 mt-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                {{ $report->reporter->Role_Pengguna }}
                            </span>
                        </div>
                        
                        <div class="mt-4 bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">ID:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $report->reporter->id_user }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Bergabung:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $report->reporter->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-500">Email:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $report->reporter->Email_Pengguna }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex space-x-2">
                            <a href="#" class="flex-1 flex justify-center items-center py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                <i class="fas fa-envelope mr-2"></i> Kirim Pesan
                            </a>
                            <a href="#" class="flex-1 flex justify-center items-center py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors text-sm font-medium">
                                <i class="fas fa-user mr-2"></i> Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Report Status Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-purple-100">
                        <h3 class="font-bold text-gray-800 flex items-center">
                            <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
                            Status Laporan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-sm text-gray-500">Status Saat Ini</div>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium
                                        {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $report->status == 'reviewed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $report->status == 'rejected' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $report->status == 'actioned' ? 'bg-green-100 text-green-800' : '' }}
                                    ">
                                        @if($report->status == 'pending')
                                            <i class="fas fa-clock mr-2"></i> Menunggu Tindakan
                                        @elseif($report->status == 'reviewed')
                                            <i class="fas fa-eye mr-2"></i> Sudah Ditinjau
                                        @elseif($report->status == 'rejected')
                                            <i class="fas fa-times-circle mr-2"></i> Ditolak
                                        @elseif($report->status == 'actioned')
                                            <i class="fas fa-check-circle mr-2"></i> Ditindaklanjuti
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-full border-4 {{ $report->status == 'pending' ? 'border-yellow-400' : ($report->status == 'reviewed' ? 'border-blue-400' : ($report->status == 'rejected' ? 'border-gray-400' : 'border-green-400')) }} flex items-center justify-center text-xl font-bold {{ $report->status == 'pending' ? 'text-yellow-500' : ($report->status == 'reviewed' ? 'text-blue-500' : ($report->status == 'rejected' ? 'text-gray-500' : 'text-green-500')) }}">
                                @if($report->status == 'pending')
                                    <i class="fas fa-hourglass-half"></i>
                                @elseif($report->status == 'reviewed')
                                    <i class="fas fa-eye"></i>
                                @elseif($report->status == 'rejected')
                                    <i class="fas fa-times"></i>
                                @elseif($report->status == 'actioned')
                                    <i class="fas fa-check"></i>
                                @endif
                            </div>
                        </div>
                        
                        @if($report->admin)
                            <div class="mt-4">
                                <div class="text-sm text-gray-500">Ditangani Oleh</div>
                                <div class="mt-2 flex items-center">
                                    <img src="{{ $report->admin->foto ? asset('storage/'.$report->admin->foto) : 'https://ui-avatars.com/api/?name='.urlencode($report->admin->Nama_Pengguna).'&color=7F9CF5&background=EBF4FF' }}" 
                                        class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm" 
                                        alt="{{ $report->admin->Nama_Pengguna }}">
                                    <span class="ml-2 text-sm font-medium text-gray-800">{{ $report->admin->Nama_Pengguna }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <div class="text-sm text-gray-500">Waktu Penanganan</div>
                                <div class="text-sm font-medium text-gray-800 mt-1">
                                    @if($report->handled_at)
                                        @if(is_string($report->handled_at))
                                            {{ $report->handled_at }}
                                        @else
                                            {{ $report->handled_at->format('d M Y, H:i') }}
                                        @endif
                                    @else
                                        Belum ditangani
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="mt-4 text-center py-3 bg-yellow-50 rounded-lg text-yellow-800 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i> Laporan ini belum ditangani
                            </div>
                        @endif
                        
                        @if($report->admin_notes)
                            <div class="mt-4">
                                <div class="text-sm text-gray-500 mb-1">Catatan Admin</div>
                                <div class="p-3 bg-gray-50 rounded-lg text-sm text-gray-700 border border-gray-200">
                                    {{ $report->admin_notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDeleteReport() {
        document.getElementById('deleteReportModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteReportModal').classList.add('hidden');
    }
</script>
@endpush