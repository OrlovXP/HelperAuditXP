@props([
    'name'=>'',
])

@error($name)
<div class="form-error text-red-700 text-sm pt-1">
    {{ $message }}
</div>
@enderror
