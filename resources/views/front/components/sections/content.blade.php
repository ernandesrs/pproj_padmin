<h1 class="section-title fw-semibold lh-1">
    {{ $title }}
</h1>
<h2 class="section-subtitle">
    {{ $subtitle }}
</h2>
<div class="section-content text-dark-light px-3 px-lg-0 py-4">
    {!! $content->content !!}
</div>
<div class="d-grid gap-2 d-lg-flex justify-content-lg-start">
    @foreach ($buttons as $button)
        <a href="{{ $button->url }}" class="btn btn-{{ $button->style }} btn-lg px-4 me-md-2 fw-semibold"
            target="{{ $button->target }}" title="{{ $button->title }}">
            @if (($button->align ?? 'start') == 'start')
                {!! $button->icon !!} <span>{{ $button->text }}</span>
            @else
                <span>{{ $button->text }}</span> {!! $button->icon !!}
            @endif
        </a>
    @endforeach
</div>
