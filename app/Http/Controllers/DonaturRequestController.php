<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonaturRequestController extends Controller
{


    public function index(Request $request, $id_makanan)
    {
        $makanan  = Makanan::where('ID_Makanan', $id_makanan)
            ->where('ID_Pengguna', Auth::id())
            ->firstOrFail();

        $status = $request->query('status', 'All');
        $query = RequestModel::where('ID_Makanan', $id_makanan)
            ->with(['pengguna', 'makanan']);

        if ($status !== 'All' && in_array($status, ['Pending', 'Approved', 'Done', 'Rejected'])) {
            $query->where('Status_Request', $status);
        }

        $requests = $query->latest()->get();

        return view('donatur.request.index', compact('requests', 'makanan'));
    }

    public function show($id_request)
    {
        $request = RequestModel::where('ID_Request', $id_request)
            ->with(['makanan', 'makanan.donatur', 'pengguna'])
            ->firstOrFail();

        // Pastikan donatur memiliki makanan ini
        if ($request->makanan->ID_Pengguna !== Auth::id() && Auth::user()->Role_Pengguna !== 'Admin') {
            return redirect()->route('donatur.food-listing.index')
                ->with('error', 'Anda tidak memiliki izin untuk melihat permintaan ini.');
        }

        return view('donatur.request.show', compact('request'));
    }

    public function update(Request $request, $id)
    {
        $requestData = RequestModel::findOrFail($id);
        
        if ($request->has('status_request')) {
            $requestData->Status_Request = $request->status_request;
        }
        
        if ($request->has('status_pengambilan')) {
            $requestData->Status_Pengambilan = $request->status_pengambilan;
            
            // Jika status pengambilan diubah menjadi Siap_Diambil
            if ($request->status_pengambilan === 'Siap_Diambil') {
                // Pastikan jadwal pengambilan sudah diatur
                if (!$requestData->Waktu_Pengambilan) {
                    return redirect()->route('donatur.request.show', $requestData->ID_Request)
                        ->with('error', 'Jadwal pengambilan belum diatur oleh penerima.');
                }
            }
        }
        
        $requestData->save();
        
        return redirect()->route('donatur.request.index', ['id_makanan' => $requestData->ID_Makanan])
            ->with('success', 'Status permintaan berhasil diperbarui');
    }
}