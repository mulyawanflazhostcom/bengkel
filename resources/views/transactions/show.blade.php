@extends('layouts.app')

@section('title', 'Transaksi ' . $transaction->code)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">{{ $transaction->code }}</h1>
        <span class="text-muted text-capitalize">Transaksi {{ $transaction->type }}</span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-dark">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <span class="badge {{ $transaction->type === 'servis' ? 'text-bg-warning' : 'text-bg-info' }} text-capitalize fs-6">
                            {{ $transaction->type }}
                        </span>
                        @include('transactions.partials.status-badge', ['status' => $transaction->status])
                    </div>
                    <div class="text-end">
                        <div class="small text-muted">Tanggal</div>
                        <div class="fw-semibold">{{ $transaction->date->format('d/m/Y') }}</div>
                    </div>
                </div>

                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Pelanggan</dt>
                    <dd class="col-sm-8">
                        <a href="{{ route('customers.show', $transaction->customer) }}">{{ $transaction->customer->name }}</a>
                        <span class="text-muted">({{ $transaction->customer->phone }})</span>
                    </dd>

                    <dt class="col-sm-4 text-muted">Kendaraan</dt>
                    <dd class="col-sm-8">
                        @if ($transaction->vehicle)
                            <a href="{{ route('vehicles.show', $transaction->vehicle) }}">{{ $transaction->vehicle->plate_number }}</a>
                            — {{ $transaction->vehicle->brand }} {{ $transaction->vehicle->model }}
                        @else
                            —
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-muted">Mekanik / PJ</dt>
                    <dd class="col-sm-8">{{ $transaction->user->name }} <span class="badge text-bg-secondary text-uppercase">{{ $transaction->user->role }}</span></dd>

                    <dt class="col-sm-4 text-muted">Keterangan</dt>
                    <dd class="col-sm-8">{{ $transaction->description }}</dd>

                    <dt class="col-sm-4 text-muted">Total</dt>
                    <dd class="col-sm-8 fs-5 fw-bold text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4 text-muted">Dibuat</dt>
                    <dd class="col-sm-8 mb-0">{{ $transaction->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
