@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h1 class="h4 fw-bold mb-0">Pelanggan</h1>
        <span class="text-muted">Kelola data pelanggan bengkel</span>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i>Tambah Pelanggan
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('customers.index') }}" method="GET" class="row g-2">
            <div class="col">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                       placeholder="Cari nama atau no. HP...">
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
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th class="d-none d-md-table-cell">Email</th>
                    <th class="text-center">Kendaraan</th>
                    <th class="text-center d-none d-sm-table-cell">Transaksi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td><a href="{{ route('customers.show', $customer) }}">{{ $customer->name }}</a></td>
                        <td>{{ $customer->phone }}</td>
                        <td class="d-none d-md-table-cell">{{ $customer->email ?? '—' }}</td>
                        <td class="text-center">{{ $customer->vehicles_count }}</td>
                        <td class="text-center d-none d-sm-table-cell">{{ $customer->transactions_count }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                      onsubmit="return confirm('Hapus pelanggan {{ $customer->name }}? Semua kendaraan & transaksinya ikut terhapus.');">
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
                        <td colspan="6" class="text-center text-muted py-4">Belum ada pelanggan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($customers->hasPages())
        <div class="card-footer bg-white">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
