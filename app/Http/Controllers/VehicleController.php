<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::with('customer')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('plate_number', 'like', '%' . $request->q . '%')
                        ->orWhere('brand', 'like', '%' . $request->q . '%')
                        ->orWhere('model', 'like', '%' . $request->q . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('vehicles.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateVehicle($request);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['customer', 'transactions.user']);

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::orderBy('name')->get();

        return view('vehicles.edit', compact('vehicle', 'customers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $this->validateVehicle($request, $vehicle);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }

    private function validateVehicle(Request $request, ?Vehicle $vehicle = null): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'plate_number' => [
                'required', 'string', 'max:15',
                Rule::unique('vehicles', 'plate_number')->ignore($vehicle),
            ],
            'type' => ['required', Rule::in(['motor', 'mobil'])],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
        ]);
    }
}
