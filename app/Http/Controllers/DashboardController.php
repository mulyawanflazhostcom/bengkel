<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'customers' => Customer::count(),
            'vehicles' => Vehicle::count(),
            'services' => Transaction::where('type', 'servis')->count(),
            'sales' => Transaction::where('type', 'penjualan')->count(),
            'revenue' => Transaction::where('status', 'dibayar')->sum('total'),
            'pending' => Transaction::whereIn('status', ['menunggu', 'dikerjakan'])->count(),
        ];

        $latestTransactions = Transaction::with(['customer', 'vehicle', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'latestTransactions'));
    }
}
