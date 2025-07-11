@props(['items' => []])

<div class="nk-block-head-sub">
    <div class="nk-block-tools-wide">
        <ul class="breadcrumb breadcrumb-arrow">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <em class="icon ni ni-home"></em>
                </a>
            </li>
            @foreach($items as $item)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['title'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        @if(isset($item['url']))
                            <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                        @else
                            {{ $item['title'] }}
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
