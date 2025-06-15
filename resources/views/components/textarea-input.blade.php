@props([
    'disabled' => false,
    'readonly' => false,
])

@php
    $extraClass = '';

    if ($readonly) {
        $extraClass = 'bg-gray-100 text-gray-500 cursor-default';
    } elseif ($disabled) {
        $extraClass = 'bg-gray-200 text-gray-500 cursor-not-allowed';
    }
@endphp

<textarea
    {{ $disabled ? 'disabled' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {!! $attributes->merge(['class' => "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm $extraClass"]) !!}
>{{ $slot ?? '' }}</textarea>
