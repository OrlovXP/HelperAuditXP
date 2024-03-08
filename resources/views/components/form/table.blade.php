@props([
    'class'=>''
])

<table {{ $attributes }} class="table-auto min-w-full whitespace-nowrap text-sm text-left {{ $class }}">{{ $slot }}</table>
