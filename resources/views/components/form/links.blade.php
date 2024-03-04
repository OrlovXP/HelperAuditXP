@props([
    'to'=>'#'
])

<a href="{{ $to }}"
   class="font-medium text-[#13A2AF] hover:underline">
    {{ $slot }}
</a>

