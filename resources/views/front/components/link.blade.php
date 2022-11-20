@php
    $sizes = [
        'small' => '',
        'normal' => '',
        'medium' => '',
        'large' => 'btn-lg px-4 me-md-2 fw-semibold',
    ];
    $theSize = $sizes[$size ?? 'normal'];
@endphp

<a href="{{ $url }}" class="btn btn-{{ $variant }} {{ $theSize }}" target="{{ $target }}"
    title="{{ $title }}">
    @if (($position ?? 'start') == 'start')
        @if ($iconClass ?? null)
            <i class="{{ $iconClass }}"></i>
        @elseif($iconName ?? null)
            {{ Icons::elem($iconName) }}
        @elseif($iconTag ?? null)
            {!! $iconTag !!}
        @endif
        <span>{{ $text }}</span>
    @else
        <span>{{ $text }}</span>
        @if ($iconClass ?? null)
            <i class="{{ $iconClass }}"></i>
        @elseif($iconName ?? null)
            {!! Icons::elem($iconName) !!}
        @elseif($iconTag ?? null)
            {!! $iconTag !!}
        @endif
    @endif
</a>
