@props([
    'color' => 'primary',
    'icon' => null,
    'label' => null,
    'tag' => 'button',
    'type' => 'button',
])

@php
    $buttonClasses = [
        'flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-500/5 focus:outline-none filament-tables-icon-button',
        'text-primary-500 focus:bg-primary-500/10' => $color === 'primary',
        'text-danger-500 focus:bg-danger-500/10' => $color === 'danger',
        'text-gray-500 focus:bg-gray-500/10' => $color === 'secondary',
        'text-success-500 focus:bg-success-500/10' => $color === 'success',
        'text-warning-500 focus:bg-warning-500/10' => $color === 'warning',
        'hover:bg-gray-300/5' => config('filament.dark_mode'),
    ];

    $iconClasses = 'w-5 h-5 filament-tables-icon-button-icon';
@endphp

@if ($tag === 'button')
    <button
        type="{{ $type }}"
        {{ $attributes->class($buttonClasses) }}
    >
        @if ($label)
            <span class="sr-only">
                {{ $label }}
            </span>
        @endif

        <x-dynamic-component :component="$icon" :class="$iconClasses" />
    </button>
@elseif ($tag === 'a')
    <a {{ $attributes->class($buttonClasses) }}>
        @if ($label)
            <span class="sr-only">
                {{ $label }}
            </span>
        @endif

        <x-dynamic-component :component="$icon" :class="$iconClasses" />
    </a>
@endif
