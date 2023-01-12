<section class="section default-section" id="{{ Str::slug($section->name) }}">
    <div class="container">
        <div class="row justify-content-center {{ $alignment == 'center' ? '' : 'justify-content-lg-start' }} align-items-center">
            <div
                class="col-12 mb-4 {{ $alignment == 'center' ? 'col-lg-10 g-success' : ($alignment == 'right' ? 'col-lg-6 order-lg-5 mb-lg-0' : 'col-lg-6 mb-lg-0') }} p-0 d-flex justify-content-center align-items-center">
                @component('front.components.sections.images',
                    [
                        'images' => $section->images ?? [],
                        'slideOptions' => [
                            'arrows' => false,
                            'pagination' => true,
                            'autoplay' => true,
                        ],
                    ])
                @endcomponent
            </div>

            <div class="{{ $alignment == 'center' ? 'col-lg-10 col-xl-8 bg-danger' : 'col-lg-6 text-lg-start' }} text-center">
                <h1 class="section-title fw-semibold lh-1">
                    {{ $section->title }}
                </h1>
                <h2 class="section-subtitle">
                    {{ $section->subtitle }}
                </h2>
                <div class="section-content text-dark-light px-3 px-lg-0 py-4">
                    {!! $section->content !!}
                </div>
                <div class="d-grid gap-2 d-lg-flex {{ $alignment == 'center' ? 'justify-content-center' : 'justify-content-lg-start' }}">
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
