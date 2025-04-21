<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::where('ID_Pengguna', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pengguna.donation.index', compact('donations'));
    }

    public function create()
    {
        return view('pengguna.donation.create');
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

        return redirect()->route('pengguna.payment.create', ['donation_id' => $donation->id]);
    }

    public function show(Donation $donation)
    {
        if ($donation->ID_Pengguna !== Auth::user()->ID_Pengguna) {
            abort(403, 'Unauthorized access');
        }

        return view('pengguna.donation.show', compact('donation'));
    }
}



// namespace App\Http\Controllers;

// use App\Models\Donation;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class DonationController extends Controller
// {
//     public function index()
//     {
//         $donations = Donation::where('ID_Pengguna', Auth::id())
//             ->latest()
//             ->paginate(10);

//         // Determine the current route prefix
//         $routePrefix = Auth::user()->Role_Pengguna === 'Pengguna' 
//             ? 'pengguna' 
//             : 'donatur';

//         return view('pengguna.donation.index', [
//             'donations' => $donations,
//             'routePrefix' => $routePrefix
//         ]);
//     }

//     public function create()
//     {
//         // Determine the current route prefix
//         $routePrefix = Auth::user()->Role_Pengguna === 'Pengguna' 
//             ? 'pengguna' 
//             : 'donatur';

//         $layout = Auth::user()->Role_Pengguna === 'Pengguna' 
//             ? 'layouts.appdonatur' 
//             : 'layouts.app';

//         return view('pengguna.donation.create', [
//             'routePrefix' => $routePrefix
//         ]);
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'full_name' => 'required|string|max:255',
//             'phone' => 'required|numeric|min:9',
//             'nominal' => 'required|numeric|min:1',
//             'note' => 'nullable|string',
//             'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet',
//         ]);

//         $donation = Donation::create([
//             'ID_Pengguna' => auth()->id(),
//             'full_name' => $request->full_name,
//             'phone' => $request->phone,
//             'nominal' => $request->nominal,
//             'note' => $request->note,
//             'payment_method' => $request->payment_method,
//             'status' => 'Pending'
//         ]);

//         // Use the appropriate route based on the user's role
//         $routePrefix = Auth::user()->Role_Pengguna === 'Pengguna' 
//             ? 'pengguna' 
//             : 'donatur';

//         return redirect()->route("{$routePrefix}.payment.create", ['donation_id' => $donation->id]);
//     }

//     public function show(Donation $donation)
//     {
//         if ($donation->ID_Pengguna !== auth()->id()) {
//             abort(403, 'Unauthorized access');
//         }

//         // Determine the current route prefix
//         $routePrefix = Auth::user()->Role_Pengguna === 'Pengguna' 
//             ? 'pengguna' 
//             : 'donatur';

//         $layout = Auth::user()->Role_Pengguna === 'Pengguna' 
//         ? 'layouts.appdonatur' 
//         : 'layouts.app';

//         return view('pengguna.donation.show', [
//             'donation' => $donation,
//             'routePrefix' => $routePrefix
//         ]);
//     }
// }