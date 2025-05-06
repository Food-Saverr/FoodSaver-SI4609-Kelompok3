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
            ->where('id_user', Auth::id())
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
        if ($request->makanan->id_user !== Auth::id() && Auth::user()->Role_Pengguna !== 'Admin') {
            return redirect()->route('donatur.food-listing.index')
                ->with('error', 'Anda tidak memiliki izin untuk melihat permintaan ini.');
        }

        return view('donatur.request.show', compact('request'));
    }

    public function update(Request $request, $id_request)
    {
        $requestModel = RequestModel::where('ID_Request', $id_request)
            ->with('makanan')
            ->firstOrFail();

        // Pastikan donatur memiliki makanan ini
        if (
            Auth::user()->Role_Pengguna !== 'Admin' &&
            $requestModel->makanan->id_user !== Auth::id()
        ) {
            return redirect()->route('donatur.request.index', ['id_makanan' => $requestModel->makanan->ID_Makanan])
                ->with('error', 'Anda tidak memiliki izin untuk memperbarui status permintaan ini.');
        }

        // Validasi input
        $request->validate([
            'status_request' => 'required|in:Pending,Approved,Done,Rejected',
        ]);

        // Update status
        $requestModel->update([
            'Status_Request' => $request->status_request,
        ]);

        // Redirect kembali ke index dengan status filter yang sama
        return redirect()->route('donatur.request.index', [
            'id_makanan' => $requestModel->makanan->ID_Makanan,
            'status' => $request->query('status', 'All')
        ])->with('success', 'Status permintaan berhasil diperbarui.');
    }
}
