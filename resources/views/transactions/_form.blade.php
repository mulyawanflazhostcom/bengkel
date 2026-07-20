@php $selectedTrxType = old('type', $transaction->type ?? 'servis'); @endphp
<div class="mb-3">
    <label class="form-label d-block">Jenis Transaksi <span class="text-danger">*</span></label>
    <div class="btn-group w-100" role="group">
        <input type="radio" class="btn-check" name="type" id="type_servis" value="servis"
               @checked($selectedTrxType === 'servis') onchange="toggleVehicleRequired()">
        <label class="btn btn-outline-dark" for="type_servis"><i class="bi bi-wrench me-1"></i>Servis</label>
        <input type="radio" class="btn-check" name="type" id="type_penjualan" value="penjualan"
               @checked($selectedTrxType === 'penjualan') onchange="toggleVehicleRequired()">
        <label class="btn btn-outline-dark" for="type_penjualan"><i class="bi bi-bag me-1"></i>Penjualan</label>
    </div>
    @error('type')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="customer_id" class="form-label">Pelanggan <span class="text-danger">*</span></label>
        <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
            <option value="">— Pilih pelanggan —</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}"
                        @selected(old('customer_id', $transaction->customer_id ?? '') == $customer->id)>
                    {{ $customer->name }} ({{ $customer->phone }})
                </option>
            @endforeach
        </select>
        @error('customer_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger" id="vehicle_required_mark">*</span></label>
        <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id">
            <option value="">— Pilih kendaraan —</option>
            @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" data-customer="{{ $vehicle->customer_id }}"
                        @selected(old('vehicle_id', $transaction->vehicle_id ?? '') == $vehicle->id)>
                    {{ $vehicle->plate_number }} — {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->customer->name }})
                </option>
            @endforeach
        </select>
        <div class="form-text">Wajib untuk transaksi servis.</div>
        @error('vehicle_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="user_id" class="form-label">Mekanik / Penanggung Jawab <span class="text-danger">*</span></label>
        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
            <option value="">— Pilih mekanik —</option>
            @foreach ($mechanics as $mechanic)
                <option value="{{ $mechanic->id }}"
                        @selected(old('user_id', $transaction->user_id ?? auth()->id()) == $mechanic->id)>
                    {{ $mechanic->name }} ({{ $mechanic->role }})
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
               value="{{ old('date', isset($transaction) ? $transaction->date->format('Y-m-d') : date('Y-m-d')) }}" required>
        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Keterangan <span class="text-danger">*</span></label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
              rows="3" placeholder="Contoh: Ganti oli + servis rutin / Penjualan sparepart kampas rem"
              required>{{ old('description', $transaction->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-3">
        <label for="total" class="form-label">Total (Rp) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="0" class="form-control @error('total') is-invalid @enderror"
               id="total" name="total" value="{{ old('total', $transaction->total ?? '') }}" required>
        @error('total')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 col-md-6 mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            @foreach (['menunggu', 'dikerjakan', 'selesai', 'dibayar'] as $status)
                <option value="{{ $status }}"
                        @selected(old('status', $transaction->status ?? 'menunggu') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
<script>
    function toggleVehicleRequired() {
        const isService = document.getElementById('type_servis').checked;
        document.getElementById('vehicle_id').required = isService;
        document.getElementById('vehicle_required_mark').style.display = isService ? 'inline' : 'none';
    }
    toggleVehicleRequired();
</script>
@endpush
