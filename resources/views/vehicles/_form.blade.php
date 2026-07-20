<div class="mb-3">
    <label for="customer_id" class="form-label">Pemilik <span class="text-danger">*</span></label>
    <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
        <option value="">— Pilih pelanggan —</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}"
                    @selected(old('customer_id', $vehicle->customer_id ?? '') == $customer->id)>
                {{ $customer->name }} ({{ $customer->phone }})
            </option>
        @endforeach
    </select>
    @error('customer_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="plate_number" class="form-label">Nomor Plat <span class="text-danger">*</span></label>
    <input type="text" class="form-control text-uppercase @error('plate_number') is-invalid @enderror"
           id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number ?? '') }}"
           placeholder="B 1234 ABC" required>
    @error('plate_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label d-block">Jenis <span class="text-danger">*</span></label>
    @php $selectedType = old('type', $vehicle->type ?? 'motor'); @endphp
    <div class="btn-group w-100" role="group">
        <input type="radio" class="btn-check" name="type" id="type_motor" value="motor" @checked($selectedType === 'motor')>
        <label class="btn btn-outline-dark" for="type_motor"><i class="bi bi-bicycle me-1"></i>Motor</label>
        <input type="radio" class="btn-check" name="type" id="type_mobil" value="mobil" @checked($selectedType === 'mobil')>
        <label class="btn btn-outline-dark" for="type_mobil"><i class="bi bi-car-front me-1"></i>Mobil</label>
    </div>
    @error('type')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
<div class="row">
    <div class="col-12 col-sm-5 mb-3">
        <label for="brand" class="form-label">Merek <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('brand') is-invalid @enderror"
               id="brand" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" placeholder="Honda" required>
        @error('brand')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('model') is-invalid @enderror"
               id="model" name="model" value="{{ old('model', $vehicle->model ?? '') }}" placeholder="Beat" required>
        @error('model')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <label for="year" class="form-label">Tahun</label>
        <input type="number" class="form-control @error('year') is-invalid @enderror"
               id="year" name="year" value="{{ old('year', $vehicle->year ?? '') }}" placeholder="2022">
        @error('year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
