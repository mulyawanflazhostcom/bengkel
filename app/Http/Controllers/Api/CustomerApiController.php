<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerApiController extends Controller
{
    /**
     * GET /api/customers — daftar pelanggan (JSON).
     */
    public function index()
    {
        $customers = Customer::withCount(['vehicles', 'transactions'])
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pelanggan.',
            'data' => $customers,
        ]);
    }
}
