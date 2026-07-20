<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class ServiceApiController extends Controller
{
    /**
     * GET /api/services — daftar transaksi servis (JSON).
     */
    public function index()
    {
        $services = Transaction::with(['customer:id,name,phone', 'vehicle:id,plate_number,brand,model', 'user:id,name'])
            ->where('type', 'servis')
            ->latest('date')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar transaksi servis.',
            'data' => $services,
        ]);
    }
}
