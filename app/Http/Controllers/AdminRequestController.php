<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRequestController extends Controller
{

    public function index(Request $request, $id_makanan)
    {
        // Ambil data makanan
        $makanan = Makanan::where('ID_Makanan', $id_makanan)->firstOrFail();

        // Ambil filter status dari query string, default ke 'All'
        $status = $request->query('status', 'All');

        // Query permintaan berdasarkan ID_Makanan
        $query = RequestModel::where('ID_Makanan', $id_makanan)
            ->with(['pengguna', 'makanan']);

        // Terapkan filter status jika bukan 'All'
        if ($status !== 'All' && in_array($status, ['Pending', 'Approved', 'Done', 'Rejected'])) {
            $query->where('Status_Request', $status);
        }

        // Ambil data permintaan, urutkan dari yang terbaru
        $requests = $query->latest()->get();

        return view('admin.request.index', compact('requests', 'makanan'));
    }
}