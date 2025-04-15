<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Makanan;
use App\Models\Donasi;
use App\Models\Artikel;
use App\Models\Forum;
use App\Models\Diskusi;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $jumlahDonatur = User::where('role', 'donatur')->count();
        $jumlahPenerima = User::where('role', 'penerima')->count();

        $jumlahMakananTersedia = Makanan::where('status', 'tersedia')->count();
        $jumlahMakananDidonasikan = Makanan::where('status', 'didonasikan')->count();

        return view('dashboard-admin', compact(
            'jumlahDonatur',
            'jumlahPenerima',
            'jumlahMakananTersedia',
            'jumlahMakananDidonasikan',
        ));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Makanan;
use App\Models\Donasi;
use App\Models\Artikel;
use App\Models\Forum;
use App\Models\Diskusi;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
{
    $jumlahDonatur = User::where('Role_Pengguna', 'Donatur')->count();
    $jumlahPenerima = User::where('Role_Pengguna', 'Pengguna')->count();

    $jumlahMakananTersedia = Makanan::where('status', 'tersedia')->count();
    $jumlahMakananDidonasikan = Makanan::where('status', 'didonasikan')->count();

    $totalDonasi = Donasi::sum('jumlah');

    return view('dashboard-admin', compact(
        'jumlahDonatur',
        'jumlahPenerima',
        'jumlahMakananTersedia',
        'jumlahMakananDidonasikan',
        'totalDonasi',
    ));
}
public function detailDonasi()
{
    // Total donasi keseluruhan
    $totalDonasi = Donasi::sum('jumlah');

    // Statistik donasi per bulan untuk chart
    $donasiPerBulan = Donasi::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(jumlah) as total')
        )
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('bulan')
        ->get();

    return view('TotalDonasi', compact('totalDonasi', 'donasiPerBulan'));
}
}
