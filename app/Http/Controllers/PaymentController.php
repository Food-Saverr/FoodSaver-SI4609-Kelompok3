<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function index()
    {
        $invoices = session('invoice');
        return view('pengguna.payment.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $donation = Donation::where('id', $request->donation_id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();

        return view('pengguna.payment.create', compact('donation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet'
        ]);

        $donation = Donation::where('id', $request->donation_id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();

        $payment = Payment::create([
            'donation_id' => $donation->id,
            'payment_method' => $request->payment_method,
        ]);

        $invoice = Donation::select(
            'donations.id as donation_id',
            'donations.full_name',
            'donations.phone',
            'donations.status',
            'payments.payment_method',
            'nominal'
        )
            ->join('payments', 'donations.id', '=', 'payments.donation_id')
            ->where('donations.id', $donation->id)
            ->first();

        session()->put('donation_id', $donation->id);
        return redirect()->route('pengguna.payment.index')
            ->with('success', 'Payment initiated successfully')
            ->with('invoice', $invoice);
    }

    public function downloadInvoice($id)
    {
        $donation = Donation::where('id', $id)
            ->firstOrFail();

        $payment = Payment::where('donation_id', $id)->firstOrFail();

        $data = [
            'full_name' => $donation->full_name,
            'phone' => $donation->phone,
            'payment_status' => $donation->status,
            'payment_method' => $payment->payment_method,
            'nominal' => $donation->nominal,
        ];

        $pdf = Pdf::loadView('pengguna.pdf.invoice', $data);

        return $pdf->download('invoice_' . $id . '.pdf');
    }
}
