@php
    $iconPosition = $icon->position ?? 'start';
@endphp
@if (($icon ?? null) && ($position ?? null) ? $iconPosition == $position : true)
    <span
        class="{{ $icon->source == 'html' ? $icon->class : null }} {{ $position ?? false ? ($iconPosition == 'start' ? 'me-1' : 'ms-1') : null }}">
        @if ($icon->source == 'local')
            {!! Icons::elem($icon->name) !!}
        @endif
    </span>
@endif
