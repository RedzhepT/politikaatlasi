@props(['paginator'])

@if ($paginator->hasPages())
<div class="admin-pagination">
    <div class="pagination-wrapper">
        <div class="pagination-nav">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-button disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-button">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Numbered Page Links --}}
            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($paginator->currentPage() + 2, $paginator->lastPage());
            @endphp

            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="page-button">1</a>
                @if($start > 2)
                    <span class="page-button disabled">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $paginator->currentPage())
                    <span class="page-button active">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->url($i) }}" class="page-button">{{ $i }}</a>
                @endif
            @endfor

            @if($end < $paginator->lastPage())
                @if($end < $paginator->lastPage() - 1)
                    <span class="page-button disabled">...</span>
                @endif
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-button">{{ $paginator->lastPage() }}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-button">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="page-button disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif
        </div>
        <div class="page-info">
            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} / {{ $paginator->total() }}
        </div>
    </div>
</div>
@endif 