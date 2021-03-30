@if ($paginator->lastPage() > 1)
    <nav>
        <ul class="pagination">
            <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            	<a href="{{ $paginator->url(1) }}"><span><i class="icon-angle-left"></i></span></a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li  class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            	<a href="{{ $paginator->url($paginator->currentPage()+1) }}"><span><i class="icon-angle-right"></i></span></a>
            </li>
        </ul>
    </nav>
@endif
