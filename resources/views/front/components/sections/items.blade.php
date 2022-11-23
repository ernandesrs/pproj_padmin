<section class="section default-section {{ $alignment ?? 'left' }}-section" id="{{ Str::slug($section->name) }}">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 col-sm-10 col-lg-8 col-xl-6 text-center px-5">
                <h1 class="section-title fw-semibold lh-1">
                    {{ $section->title }}
                </h1>
                <h2 class="section-subtitle">
                    {{ $section->subtitle }}
                </h2>
            </div>

            <div class="col-12 col-lg-10 py-4">
                <div class="row justify-content-center">
                    @foreach ($items as $item)
                        <div class="col-10 col-sm-6 col-md-4 mb-4 mb-lg-0">
                            <div class="card card-body border-0">
                                <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                                    <div class="icon fs-2 py-2 px-3 bg-secondary rounded-5 text-light">
                                        {!! $item->icon !!}
                                    </div>
                                    <div class="text-center">
                                        <h2 class="fs-5 fw-semibold mb-0 py-2">{{ $item->title }}</h2>
                                        <p class="">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <div class="d-grid gap-2 d-flex justify-content-center">
                    @foreach ($section->buttons as $button)
                        @component('front.components.link',
                            [
                                'url' => $button->url,
                                'variant' => $button->style,
                                'size' => 'large',
                                'target' => $button->target,
                                'title' => $button->title,
                                'iconTag' => $button->icon,
                                // 'iconClass' => 'bi bi-4-square',
                                // 'iconName' => 'appIndicator',
                                'position' => $button->position,
                                'text' => $button->text,
                            ])
                        @endcomponent
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
