@props([
    'class'=>''
])

<td {{ $attributes }} class="px-2 py-3 whitespace-nowrap {{ $class }}">{{ $slot }}</td>
