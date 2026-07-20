@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">Dashboard</h1>
        <span class="text-muted">Ringkasan aktivitas bengkel</span>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i>Transaksi Baru
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-people"></i></div>
                <div>
                    <div class="fs-4 fw-bold">{{ $stats['customers'] }}</div>
                    <div class="text-muted small">Pelanggan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-car-front"></i></div>
                <div>
                    <div class="fs-4 fw-bold">{{ $stats['vehicles'] }}</div>
                    <div class="text-muted small">Kendaraan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-wrench"></i></div>
                <div>
                    <div class="fs-4 fw-bold">{{ $stats['services'] }}</div>
                    <div class="text-muted small">Servis</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info-subtle text-info"><i class="bi bi-bag"></i></div>
                <div>
                    <div class="fs-4 fw-bold">{{ $stats['sales'] }}</div>
                    <div class="text-muted small">Penjualan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Total Pendapatan (dibayar)</div>
                <div class="fs-4 fw-bold text-success">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-muted small mb-1">Pekerjaan Berjalan</div>
                <div class="fs-4 fw-bold text-warning">{{ $stats['pending'] }} transaksi</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Transaksi Terbaru</span>
        <a href="{{ route('transactions.index') }}" class="small">Lihat semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Pelanggan</th>
                    <th class="d-none d-md-table-cell">Kendaraan</th>
                    <th class="d-none d-md-table-cell">Mekanik</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestTransactions as $trx)
                    <tr>
                        <td><a href="{{ route('transactions.show', $trx) }}">{{ $trx->code }}</a></td>
                        <td>
                            <span class="badge {{ $trx->type === 'servis' ? 'text-bg-warning' : 'text-bg-info' }} text-capitalize">
                                {{ $trx->type }}
                            </span>
                        </td>
                        <td>{{ $trx->customer->name }}</td>
                        <td class="d-none d-md-table-cell">{{ $trx->vehicle->plate_number ?? '—' }}</td>
                        <td class="d-none d-md-table-cell">{{ $trx->user->name }}</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>@include('transactions.partials.status-badge', ['status' => $trx->status])</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
