@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <h1 class="h4 fw-bold mb-4">Transaksi Baru</h1>
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    @include('transactions._form')
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
