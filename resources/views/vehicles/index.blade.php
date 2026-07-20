@extends('layouts.app')

@section('title', 'Kendaraan')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">Kendaraan</h1>
        <span class="text-muted">Kelola data kendaraan pelanggan</span>
    </div>
    <a href="{{ route('vehicles.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kendaraan
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('vehicles.index') }}" method="GET" class="row g-2">
            <div class="col">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                       placeholder="Cari plat, merek, atau model...">
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
                    <th>Plat</th>
                    <th>Jenis</th>
                    <th>Merek / Model</th>
                    <th class="d-none d-sm-table-cell">Tahun</th>
                    <th class="d-none d-md-table-cell">Pemilik</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td><a href="{{ route('vehicles.show', $vehicle) }}">{{ $vehicle->plate_number }}</a></td>
                        <td>
                            <span class="badge {{ $vehicle->type === 'motor' ? 'text-bg-secondary' : 'text-bg-dark' }} text-capitalize">
                                <i class="bi {{ $vehicle->type === 'motor' ? 'bi-bicycle' : 'bi-car-front' }} me-1"></i>{{ $vehicle->type }}
                            </span>
                        </td>
                        <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                        <td class="d-none d-sm-table-cell">{{ $vehicle->year ?? '—' }}</td>
                        <td class="d-none d-md-table-cell">
                            <a href="{{ route('customers.show', $vehicle->customer) }}">{{ $vehicle->customer->name }}</a>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                                      onsubmit="return confirm('Hapus kendaraan {{ $vehicle->plate_number }}?');">
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
                        <td colspan="6" class="text-center text-muted py-4">Belum ada kendaraan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($vehicles->hasPages())
        <div class="card-footer bg-white">
            {{ $vehicles->links() }}
        </div>
    @endif
</div>
@endsection
