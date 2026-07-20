@php
    $badgeClass = match ($status) {
        'menunggu' => 'text-bg-secondary',
        'dikerjakan' => 'text-bg-warning',
        'selesai' => 'text-bg-primary',
        'dibayar' => 'text-bg-success',
        default => 'text-bg-light',
    };
@endphp
<span class="badge {{ $badgeClass }} text-capitalize">{{ $status }}</span>
