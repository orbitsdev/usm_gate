@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-[#FDDC01]  focus:ring-[#FDDC01]   focus:border-none  focus:border-[#FDDC01]  rounded-md shadow-sm']) !!}>
