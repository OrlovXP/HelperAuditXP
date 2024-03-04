@props([
    'class'=>''
])

<th {{ $attributes }} class="px-2 py-3 whitespace-nowrap {{ $class }}">{{ $slot }}</th>
