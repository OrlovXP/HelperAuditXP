@props([
    'type'=>'text',
    'name'=>'',
])

<input type="{{ $type }}" name="{{ $name }}" {{ $attributes }} value="{{ old($name) }}" class="border-gray-300/50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-[#13A2AF]/30 focus:border-[#13A2AF]/30 block w-full p-2.5 outline-none">

<x-form.error name="{{ $name }}"/>
