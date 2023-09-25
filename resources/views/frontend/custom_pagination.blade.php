@if ($paginator->hasPages())
<div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link"><i class="fi-rs-arrow-small-left"></i></a>
            </li>
               
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fi-rs-arrow-small-left"></i></a>
            </li>
                
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><a class="page-link">{{ $page }}</a></li>

                        @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>

                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fi-rs-arrow-small-right"></i></a>
            </li>
               
            @else
               
            @endif
        </ul>
    </nav>
</div>

@endif
