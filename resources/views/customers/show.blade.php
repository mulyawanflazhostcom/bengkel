@extends('layouts.app')

@section('title', $customer->name)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">{{ $customer->name }}</h1>
        <span class="text-muted">Detail pelanggan</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Informasi Kontak</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="small text-muted">No. HP</dt>
                    <dd>{{ $customer->phone }}</dd>
                    <dt class="small text-muted">Email</dt>
                    <dd>{{ $customer->email ?? '—' }}</dd>
                    <dt class="small text-muted">Alamat</dt>
                    <dd class="mb-0">{{ $customer->address ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card mb-3">
            <div class="card-header bg-white fw-semibold">Kendaraan ({{ $customer->vehicles->count() }})</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Plat</th>
                            <th>Jenis</th>
                            <th>Merek / Model</th>
                            <th class="d-none d-sm-table-cell">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer->vehicles as $vehicle)
                            <tr>
                                <td><a href="{{ route('vehicles.show', $vehicle) }}">{{ $vehicle->plate_number }}</a></td>
                                <td class="text-capitalize">{{ $vehicle->type }}</td>
                                <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                                <td class="d-none d-sm-table-cell">{{ $vehicle->year ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada kendaraan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white fw-semibold">Riwayat Transaksi ({{ $customer->transactions->count() }})</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Jenis</th>
                            <th class="d-none d-sm-table-cell">Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer->transactions as $trx)
                            <tr>
                                <td><a href="{{ route('transactions.show', $trx) }}">{{ $trx->code }}</a></td>
                                <td class="text-capitalize">{{ $trx->type }}</td>
                                <td class="d-none d-sm-table-cell">{{ $trx->date->format('d/m/Y') }}</td>
                                <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                <td>@include('transactions.partials.status-badge', ['status' => $trx->status])</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
