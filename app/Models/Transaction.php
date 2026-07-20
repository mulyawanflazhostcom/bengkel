<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['code', 'type', 'customer_id', 'vehicle_id', 'user_id', 'date', 'description', 'total', 'status'])]
class Transaction extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateCode(string $type): string
    {
        $prefix = $type === 'servis' ? 'SRV' : 'PJL';
        $last = static::where('type', $type)->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, now()->format('Ymd'), $last);
    }
}
