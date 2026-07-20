@extends('layouts.app')

@section('title', $vehicle->plate_number)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">{{ $vehicle->plate_number }}</h1>
        <span class="text-muted">{{ $vehicle->brand }} {{ $vehicle->model }} {{ $vehicle->year ? '(' . $vehicle->year . ')' : '' }}</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Detail Kendaraan</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="small text-muted">Jenis</dt>
                    <dd class="text-capitalize">{{ $vehicle->type }}</dd>
                    <dt class="small text-muted">Merek / Model</dt>
                    <dd>{{ $vehicle->brand }} {{ $vehicle->model }}</dd>
                    <dt class="small text-muted">Tahun</dt>
                    <dd>{{ $vehicle->year ?? '—' }}</dd>
                    <dt class="small text-muted">Pemilik</dt>
                    <dd class="mb-0">
                        <a href="{{ route('customers.show', $vehicle->customer) }}">{{ $vehicle->customer->name }}</a>
                        <div class="small text-muted">{{ $vehicle->customer->phone }}</div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">Riwayat Servis ({{ $vehicle->transactions->count() }})</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th class="d-none d-sm-table-cell">Tanggal</th>
                            <th>Keterangan</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicle->transactions as $trx)
                            <tr>
                                <td><a href="{{ route('transactions.show', $trx) }}">{{ $trx->code }}</a></td>
                                <td class="d-none d-sm-table-cell">{{ $trx->date->format('d/m/Y') }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $trx->description }}</td>
                                <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                <td>@include('transactions.partials.status-badge', ['status' => $trx->status])</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada riwayat servis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
