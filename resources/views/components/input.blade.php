@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-1 border-gray-600 focus:ring-0 focus:border-[#FDDC01] rounded-md shadow-sm']) !!}>

