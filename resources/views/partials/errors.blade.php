@foreach ($inputs as $input)
    @error($input)
        <p class="{{ $textColor ?? 'text-red-500' }} text-xs mt-1">{{ $message }}</p>
    @enderror
@endforeach
