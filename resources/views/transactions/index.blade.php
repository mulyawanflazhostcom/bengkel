@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">Transaksi</h1>
        <span class="text-muted">Servis dan penjualan</span>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i>Transaksi Baru
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('transactions.index') }}" method="GET" class="row g-2">
            <div class="col-12 col-sm">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                       placeholder="Cari kode atau nama pelanggan...">
            </div>
            <div class="col-6 col-sm-auto">
                <select class="form-select" name="type" onchange="this.form.submit()">
                    <option value="">Semua jenis</option>
                    <option value="servis" @selected(request('type') === 'servis')>Servis</option>
                    <option value="penjualan" @selected(request('type') === 'penjualan')>Penjualan</option>
                </select>
            </div>
            <div class="col-6 col-sm-auto">
                <select class="form-select" name="status" onchange="this.form.submit()">
                    <option value="">Semua status</option>
                    @foreach (['menunggu', 'dikerjakan', 'selesai', 'dibayar'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-dark"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Pelanggan</th>
                    <th class="d-none d-md-table-cell">Kendaraan</th>
                    <th class="d-none d-lg-table-cell">Mekanik</th>
                    <th class="d-none d-sm-table-cell">Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $trx)
                    <tr>
                        <td><a href="{{ route('transactions.show', $trx) }}">{{ $trx->code }}</a></td>
                        <td>
                            <span class="badge {{ $trx->type === 'servis' ? 'text-bg-warning' : 'text-bg-info' }} text-capitalize">
                                {{ $trx->type }}
                            </span>
                        </td>
                        <td>{{ $trx->customer->name }}</td>
                        <td class="d-none d-md-table-cell">{{ $trx->vehicle->plate_number ?? '—' }}</td>
                        <td class="d-none d-lg-table-cell">{{ $trx->user->name }}</td>
                        <td class="d-none d-sm-table-cell">{{ $trx->date->format('d/m/Y') }}</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>@include('transactions.partials.status-badge', ['status' => $trx->status])</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('transactions.edit', $trx) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('transactions.destroy', $trx) }}" method="POST"
                                      onsubmit="return confirm('Hapus transaksi {{ $trx->code }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($transactions->hasPages())
        <div class="card-footer bg-white">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
