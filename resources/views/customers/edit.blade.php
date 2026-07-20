@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <h1 class="h4 fw-bold mb-4">Edit Pelanggan</h1>
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('customers._form')
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-save me-1"></i>Perbarui
                        </button>
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
