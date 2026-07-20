<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['customer', 'vehicle', 'user'])
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('code', 'like', '%' . $request->q . '%')
                        ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', '%' . $request->q . '%'));
                });
            })
            ->latest('date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create', $this->formData());
    }

    public function store(Request $request)
    {
        $validated = $this->validateTransaction($request);
        $validated['code'] = Transaction::generateCode($validated['type']);

        Transaction::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'vehicle', 'user']);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', array_merge(compact('transaction'), $this->formData()));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $this->validateTransaction($request);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'customers' => Customer::orderBy('name')->get(),
            'vehicles' => Vehicle::with('customer')->orderBy('plate_number')->get(),
            'mechanics' => User::orderBy('name')->get(),
        ];
    }

    private function validateTransaction(Request $request): array
    {
        return $request->validate([
            'type' => ['required', Rule::in(['servis', 'penjualan'])],
            'customer_id' => ['required', 'exists:customers,id'],
            'vehicle_id' => [
                Rule::requiredIf($request->type === 'servis'),
                'nullable',
                'exists:vehicles,id',
            ],
            'user_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:2000'],
            'total' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['menunggu', 'dikerjakan', 'selesai', 'dibayar'])],
        ]);
    }
}
