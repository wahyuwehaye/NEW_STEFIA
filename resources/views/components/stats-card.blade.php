@props([
    'title',
    'value',
    'icon' => 'ni-dashlite',
    'color' => 'primary',
    'change' => null,
    'changeType' => 'up',
    'subtitle' => 'vs last month',
    'tooltip' => null,
    'chartId' => null
])

<div class="col-xxl-3 col-md-6">
    <div class="card">
        <div class="nk-ecwg nk-ecwg6">
            <div class="card-inner">
                <div class="card-title-group">
                    <div class="card-title">
                        <h6 class="title">{{ $title }}</h6>
                    </div>
                    @if($tooltip)
                    <div class="card-tools">
                        <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $tooltip }}"></em>
                    </div>
                    @endif
                </div>
                <div class="data">
                    <div class="data-group">
                        <div class="amount">{{ $value }}</div>
                        @if($chartId)
                        <div class="nk-ecwg6-ck">
                            <canvas class="ecommerce-line-chart-s3" id="{{ $chartId }}"></canvas>
                        </div>
                        @endif
                    </div>
                    @if($change)
                    <div class="info">
                        <span class="change {{ $changeType }} {{ $changeType === 'up' ? 'text-success' : 'text-warning' }}">
                            <em class="icon ni ni-arrow-long-{{ $changeType }}"></em>{{ $change }}
                        </span>
                        <span class="sub">{{ $subtitle }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
