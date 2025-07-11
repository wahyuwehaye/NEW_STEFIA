@props([
    'title',
    'subtitle' => null,
    'breadcrumbs' => [],
    'actions' => null
])

<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">{{ $title }}</h3>
            @if($subtitle)
            <div class="nk-block-des text-soft">
                <p>{{ $subtitle }}</p>
            </div>
            @endif
        </div>
        @if($actions || count($breadcrumbs) > 0)
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                    <em class="icon ni ni-menu-alt-r"></em>
                </a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    @if($actions)
                        {{ $actions }}
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    
    @if(count($breadcrumbs) > 0)
        <x-breadcrumb :items="$breadcrumbs" />
    @endif
</div>
