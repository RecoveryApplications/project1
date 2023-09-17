@if ($paginator->hasPages())
<nav aria-label="Page navigation example">
    <ul class="clearfix">
        @if ($paginator->onFirstPage())
            <li >
                <a class="page-link" href="#" tabindex="-1"><span class="fa fa-angle-left"></span></a>
            </li>
        @else
            <li><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><span class="fa fa-angle-left"></span></a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled">{{ $element }}</li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li >
                            <a class="active">{{ $page }}</a>
                        </li>
                    @else
                        <li >
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li >
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><span class="fa fa-angle-right"></span></a>
            </li>
        @else
            <li class=" disabled">
                <a class="page-link" href="#"><span class="fa fa-angle-right"></span></a>
            </li>
        @endif
    </ul>
@endif
