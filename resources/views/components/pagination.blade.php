@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="sn-pagination">
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" style="opacity:0.5;">← Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next →</a>
        @else
            <span aria-disabled="true" style="opacity:0.5;">Next →</span>
        @endif
    </nav>
@endif
