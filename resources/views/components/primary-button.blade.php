@php
$class = 'bg-blue-500 text-white uppercase font-semibold text-xs py-1.5 px-10 rounded-2xl hover:bg-blue-600';
@endphp

@if ($link ?? false)
    <a href="{{ $link }}" class="{{ $class }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type ?? 'submit' }}" class="{{ $class }}">
        {{ $slot }}
    </button>
@endif
