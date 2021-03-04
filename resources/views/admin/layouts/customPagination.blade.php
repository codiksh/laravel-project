    <style>
        .shop_page_number li .page-numbers.current {
            background: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .shop_page_number li .page-numbers {
            width: 28px;
            height: 28px;
            /* border-radius: 50%; */
            border: 1px solid #e7e7f6;
            font-size: 16px;
            /* line-height: 39px; */
            font-weight: 400;
            color: #677294;
            text-align: center;
            display: block;
            -webkit-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        [class^="ti-"], [class*=" ti-"] {
            font-family: 'themify';
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            line-height: 1;

            /* Better Font Rendering =========== */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
@if ($paginator->hasPages())
    <nav class="float-sm-right">
        <ul class="col-lg-12 list-unstyled page-numbers shop_page_number text-left pagination" style="margin-top: 13px;margin-bottom: 0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                {{--                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">--}}
                {{--                    <span aria-current="page" class="page-numbers current"><i class="ti-arrow-left"></i></span>--}}
                {{--                </li>--}}
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="prev page-numbers" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-arrow-left fa-sm"></i>
                    </a>
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
                            <li>
                                <span aria-current="page" class="page-numbers current">{{ $page }}</span>
                            </li>
                        @else
                            <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </li>
            @else
                {{--                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
                {{--                    <span aria-current="page" class="page-numbers current"><i class="ti-arrow-right"></i></span>--}}
                {{--                </li>--}}
            @endif
        </ul>
    </nav>
@endif
