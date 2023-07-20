@props(['name'])
@error($name)
    <p class="text-center text-danger">{{ $message }}</p>
@enderror
