<nav>
    <ul class="pagination flat pagination-success">
    @if ($paginator->onFirstPage())

            <li class="page-item disabled">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" tabindex="-1">
                    <i class="mdi mdi-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @else
          
            <li class="page-item ">
                <a class="page-link" href="{{$paginator->previousPageUrl() }}" tabindex="-1">
                    <i class="mdi mdi-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item active">
                  <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
            </li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item"><span>...</span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active"> <a  class="page-link">{{ $i }}</a></li>
                @else
                    <li class="page-item"> <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
    @if($paginator->currentPage() < $paginator->lastPage() - 3)
        <li class="page-item"><span>...</span></li>
    @endif
    @if($paginator->currentPage() < $paginator->lastPage() - 2)
        <li class="page-item"><a  href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link" >{{ $paginator->lastPage() }}</a></li>
    @endif

    @if ($paginator->hasMorePages())

      <li class="page-item">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
            <i class="mdi mdi-chevron-right"></i>
            <span class="sr-only">Next</span>
        </a>
       </li>
       @else
       <li class="page-item disabled">
        <a class="page-link" href="#">
            <i class="mdi mdi-chevron-right"></i>
            <span class="sr-only"></span>
        </a>
       </li>
      @endif
    </ul>
  </nav>

  