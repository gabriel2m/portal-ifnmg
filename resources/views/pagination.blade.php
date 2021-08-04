@php
$chevronClass = 'text-2xl leading-tight';
$disableClass = 'text-blue-gray-300';
@endphp

<div class="flex justify-between text-blue-gray-600">
    <p class="text-sm font-semibold my-auto">
        Exibindo {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} de {{ $paginator->total() }}
    </p>

    <div>
        @if ($paginator->hasPages())
            <nav class="grid grid-flow-col gap-4 text-xl">
                {{-- Previous Page Link --}}
                <div>
                    @php
                        $prev = '<span class="' . $chevronClass . '">&lsaquo;</span>';
                    @endphp
                    @if ($paginator->onFirstPage())
                        <div class="{{ $disableClass }}">
                            {!! $prev !!}
                        </div>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}">
                            {!! $prev !!}
                        </a>
                    @endif
                </div>

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <div>{{ $element }}</div>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <div class="{{ $disableClass }}">{{ $page }}</div>
                            @else
                                <div><a href="{{ $url }}">{{ $page }}</a></div>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                <div>
                    @php
                        $next = '<span class="' . $chevronClass . '">&rsaquo;</span>';
                    @endphp
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}">
                            {!! $next !!}
                        </a>
                    @else
                        <div class="{{ $disableClass }}">
                            {!! $next !!}
                        </div>
                    @endif
                </div>
            </nav>
        @endif
    </div>
</div>
