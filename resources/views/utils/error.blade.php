@error($input)
    <p @class([$color ?? 'text-red-500', 'text-xs mt-1', $class ?? ''])>{{ $message }}</p>
@enderror
