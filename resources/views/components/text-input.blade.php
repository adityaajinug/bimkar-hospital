@props(['disabled' => false])

@php
    $extraClass = '';
    if ($attributes->get('readonly')) {
        $extraClass = 'bg-gray-100 text-gray-500 cursor-default';
    } elseif ($disabled) {
        $extraClass = 'bg-gray-200 text-gray-500 cursor-not-allowed';
    }
@endphp

<input 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm $extraClass"]) !!}
>