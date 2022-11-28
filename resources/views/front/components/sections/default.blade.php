<section class="section default-section {{ $alignment ?? 'left' }}-section" id="{{ Str::slug($section->name) }}">
    <div class="container">
        <div class="row justify-content-center justify-content-lg-start align-items-center">
            <div
                class="col-lg-6 {{ ($alignment ?? 'left') == 'right' ? 'order-lg-5' : '' }} d-flex justify-content-center mb-4 mb-lg-0">
                @component('front.components.sections.images',
                    [
                        'image' => $section->content->image ?? null,
                        'images' => $section->content->images ?? [],
                        'slideOptions' => [
                            'arrows' => false,
                            'pagination' => true,
                            'autoplay' => true,
                        ],
                    ])
                @endcomponent
            </div>

            <div class="col-lg-6 text-center text-lg-start {{ ($alignment ?? 'left') == 'right' ? 'order-lg-1' : '' }}">
                <h1 class="section-title fw-semibold lh-1">
                    {{ $section->title }}
                </h1>
                <h2 class="section-subtitle">
                    {{ $section->subtitle }}
                </h2>
                <div class="section-content text-dark-light px-3 px-lg-0 py-4">
                    {!! $section->content->content !!}
                </div>
                <div class="d-grid gap-2 d-lg-flex justify-content-lg-start">
                    @foreach ($section->buttons as $button)
                        @component('front.components.link',
                            [
                                'url' => $button->url,
                                'variant' => $button->style,
                                'size' => 'large',
                                'target' => $button->target,
                                'title' => $button->title,
                                'iconTag' => $button->icon,
                                'text' => $button->text,
                                'icon' => $button->icon,
                            ])
                        @endcomponent
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
