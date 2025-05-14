<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function store(Request $request, $id_makanan)
    {
        // Validate the request
        $request->validate([
            'pesan' => 'nullable|string|max:255',
        ]);

        // Find the Makanan or fail
        $makanan = Makanan::findOrFail($id_makanan);

        // Check if the Makanan is available and not expired
        if ($makanan->Jumlah_Makanan <= 0 || 
            $makanan->Status_Makanan === 'Habis' || 
            \Carbon\Carbon::parse($makanan->Tanggal_Kedaluwarsa)->isPast()) {
            return redirect()->route('pengguna.food-listing.show', $id_makanan)
                ->with('error', 'Makanan tidak tersedia atau sudah kedaluwarsa.');
        }

        // Create the request
        RequestModel::create([
            'ID_Makanan' => $id_makanan,
            'ID_Pengguna' => Auth::id(),
            'Pesan' => $request->pesan,
            'Status_Request' => 'Pending',
        ]);

        return redirect()->route('pengguna.request.index')
            ->with('success', 'Permintaan makanan berhasil dikirim.');
    }

    public function history(Request $request)
    {
        $status = $request->query('status', 'All');
        $query = RequestModel::where('ID_Pengguna', Auth::id())->with('makanan');

        if ($status !== 'All' && in_array($status, ['Pending', 'Approved', 'Done', 'Rejected'])) {
            $query->where('Status_Request', $status);
        }

        $requests = $query->latest()->get();

        return view('pengguna.request.index', compact('requests'));
    }

    public function show($id_request)
    {
        $request = RequestModel::where('ID_Pengguna', Auth::id())
            ->where('ID_Request', $id_request)
            ->with(['makanan', 'makanan.donatur'])
            ->firstOrFail();

        return view('pengguna.request.show', compact('request'));
    }

    public function cancel(Request $request, $id_request)
    {
        $requestModel = RequestModel::where('ID_Pengguna', Auth::id())
            ->where('ID_Request', $id_request)
            ->firstOrFail();

        // Only allow cancellation for Pending status
        if ($requestModel->Status_Request !== 'Pending') {
            return redirect()->route('pengguna.request.index', ['status' => $request->query('status', 'All')])
                ->with('error', 'Hanya permintaan dengan status Pending yang dapat dibatalkan.');
        }

        // Update status to Rejected instead of deleting
        $requestModel->update([
            'Status_Request' => 'Rejected',
        ]);

        return redirect()->route('pengguna.request.index', ['status' => $request->query('status', 'All')])
            ->with('success', 'Permintaan berhasil dibatalkan.');
    }

    public function updatePickup(Request $request, $id_request)
    {
        $requestModel = RequestModel::where('ID_Request', $id_request)
            ->where('ID_Pengguna', Auth::id())
            ->firstOrFail();

        // Validate that the request is in approved status
        if ($requestModel->Status_Request !== 'Approved') {
            return redirect()->route('pengguna.request.show', $id_request)
                ->with('error', 'Hanya permintaan yang sudah disetujui yang dapat mengatur pengambilan.');
        }

        // Validate input
        $request->validate([
            'waktu_pengambilan' => 'required|date|after:now',
            'alamat_pengambilan' => 'required|string|max:255',
        ]);

        // Update pickup details
        $requestModel->update([
            'Waktu_Pengambilan' => $request->waktu_pengambilan,
            'Alamat_Pengambilan' => $request->alamat_pengambilan,
            'Status_Pengambilan' => 'Dijadwalkan'
        ]);

        return redirect()->route('pengguna.request.show', $id_request)
            ->with('success', 'Jadwal pengambilan berhasil diatur.');
    }

    public function editPickup(Request $request, $id_request)
    {
        $requestModel = RequestModel::where('ID_Request', $id_request)
            ->where('ID_Pengguna', Auth::id())
            ->firstOrFail();

        // Validate that the request is in approved status and has been scheduled
        if ($requestModel->Status_Request !== 'Approved' || $requestModel->Status_Pengambilan !== 'Dijadwalkan') {
            return redirect()->route('pengguna.request.show', $id_request)
                ->with('error', 'Hanya jadwal pengambilan yang sudah diatur yang dapat diubah.');
        }

        // Validate input
        $request->validate([
            'waktu_pengambilan' => 'required|date|after:now',
            'alamat_pengambilan' => 'required|string|max:255',
        ]);

        // Update pickup details
        $requestModel->update([
            'Waktu_Pengambilan' => $request->waktu_pengambilan,
            'Alamat_Pengambilan' => $request->alamat_pengambilan,
        ]);

        return redirect()->route('pengguna.request.show', $id_request)
            ->with('success', 'Jadwal pengambilan berhasil diperbarui.');
    }

    public function cancelPickup(Request $request, $id_request)
    {
        $requestModel = RequestModel::where('ID_Request', $id_request)
            ->where('ID_Pengguna', Auth::id())
            ->firstOrFail();

        // Validate that the request is in approved status and has been scheduled
        if ($requestModel->Status_Request !== 'Approved' || $requestModel->Status_Pengambilan !== 'Dijadwalkan') {
            return redirect()->route('pengguna.request.show', $id_request)
                ->with('error', 'Hanya jadwal pengambilan yang sudah diatur yang dapat dibatalkan.');
        }

        // Validate input
        $request->validate([
            'catatan_pembatalan' => 'required|string|max:255',
        ]);

        // Update pickup status
        $requestModel->update([
            'Status_Pengambilan' => 'Dibatalkan',
            'Catatan_Pembatalan' => $request->catatan_pembatalan,
        ]);

        return redirect()->route('pengguna.request.show', $id_request)
            ->with('success', 'Jadwal pengambilan berhasil dibatalkan.');
    }

    public function update(Request $request, $id_request)
    {
        $requestModel = RequestModel::where('ID_Request', $id_request)
            ->with('makanan')
            ->firstOrFail();

        // Validate that only Admin or related Donatur can update
        if (Auth::user()->Role_Pengguna !== 'Admin' && 
            !(Auth::user()->Role_Pengguna === 'Donatur' && $requestModel->makanan->ID_Pengguna === Auth::id())) {
            return redirect()->route('pengguna.request.show', $id_request)
                ->with('error', 'Anda tidak memiliki izin untuk memperbarui status permintaan ini.');
        }

        // Validate input
        $request->validate([
            'status_request' => 'required|in:Pending,Approved,Done,Rejected',
        ]);

        // Update status
        $requestModel->update([
            'Status_Request' => $request->status_request,
        ]);

        return redirect()->route('pengguna.request.show', $id_request)
            ->with('success', 'Status permintaan berhasil diperbarui.');
    }
}