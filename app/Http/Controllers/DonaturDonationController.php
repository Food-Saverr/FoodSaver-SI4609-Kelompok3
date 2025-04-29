<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonaturDonationController extends Controller
{
    public function index()
    {
        $donations = Donation::where('ID_Pengguna', Auth::id())
            ->latest()
            ->paginate(10);

        return view('donatur.donation.index', compact('donations'));
    }

    public function create()
    {
        return view('donatur.donation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:9',
            'nominal' => 'required|numeric|min:1',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet',
        ]);

        $donation = Donation::create([
            'ID_Pengguna' => Auth::user()->ID_Pengguna,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'nominal' => $request->nominal,
            'note' => $request->note,
            'payment_method' => $request->payment_method,
            'status' => 'Pending'
        ]);

        return redirect()->route('donatur.payment.create', ['donation_id' => $donation->id]);
    }

    public function show(Donation $donation)
    {
        if ($donation->ID_Pengguna !== Auth::user()->ID_Pengguna) {
            abort(403, 'Unauthorized access');
        }

        return view('donatur.donation.show', compact('donation'));
    }
}