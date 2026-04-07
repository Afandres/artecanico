@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500 bg-white focus:bg-white rounded-md shadow-sm']) !!}>
