<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('pengguna')->latest()->paginate(10);

        if ($donations->isEmpty()) {
            return view('donation.index')->with('donations', collect());
        }

        return view('donation.index', compact('donations'));
    }

    public function create()
    {
        return view('donation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:9',
            'nominal' => 'required|numeric|min:1',
            'note' => 'nullable|string',
        ]);

        Donation::create([
            // 'ID_Pengguna' => auth()->id(),
            'ID_Pengguna' => auth()->id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'nominal' => $request->nominal,
            'note' => $request->note,
            'status' => 'Pending'
        ]);

        return redirect()->route('donation.index')->with('success', 'Donasi berhasil dikirim!');
    }

    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'status' => 'required|in:Pending,Disetujui',
        ]);

        $donation->update([
            'status' => $request->status,
        ]);

        return redirect()->route('donation.index')->with('success', 'Status donasi berhasil diubah!');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donation.index')->with('success', 'Donasi berhasil dihapus!');
    }
}
