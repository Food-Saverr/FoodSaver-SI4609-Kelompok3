<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('pengguna')
            ->latest()
            ->paginate(10);

        if ($donations->isEmpty()) {
            $donations = new LengthAwarePaginator([], 0, 10); // total, perPage
        }

        return view('admin.donation.index', compact('donations'));
    }

    public function show(Donation $donation)
    {
        $donation->load('pengguna');

        return view('admin.donation.show', compact('donation'));
    }

    public function destroy(Donation $donation)
    {
        try {
            $donation->delete();
            
            return redirect()->route('admin.donation.index')
                ->with('success', 'Donasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.donation.index')
                ->with('error', 'Gagal menghapus donasi: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $request->validate([
            'status' => 'required|in:Pending,Disetujui',
        ]);

        $donation->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.donation.index')
            ->with('success', 'Status donasi berhasil diperbarui!');
    }
}