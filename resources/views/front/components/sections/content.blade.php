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
        @component('front.components.link',
            [
                'url' => $button->url,
                'variant' => $button->style,
                'size' => 'large',
                'target' => $button->target,
                'title' => $button->title,
                'iconTag' => $button->icon,
                // 'iconClass' => 'bi bi-4-square',
                'position' => $button->position,
                'text' => $button->text,
            ])
        @endcomponent
    @endforeach
</div>
