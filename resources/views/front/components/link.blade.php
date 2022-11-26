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
    @component('front.components.icon',
        [
            'icon' => $icon,
            'position' => 'start',
        ])
    @endcomponent
    <span>{{ $text }}</span>
    @component('front.components.icon',
        [
            'icon' => $icon,
            'position' => 'end',
        ])
    @endcomponent
</a>
