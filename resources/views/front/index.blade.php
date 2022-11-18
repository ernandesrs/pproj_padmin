@extends('layouts.front')

@section('content')
    @if ($section_1)
        <section class="section section-banner">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-start align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0 d-flex justify-content-center align-items-center">
                        <div class="d-flex align-items-center banner-image">
                            @if ($section_1->type == 2)
                                <div class="splide jsSplideDefault" role="group" aria-label="Splide Basic HTML Example">
                                    <div class="splide__track">
                                        <ul class="splide__list">
                                            @foreach ($section_1->content->images ?? [] as $image)
                                                <li class="splide__slide">
                                                    <img class="rounded-lg-3" src="{{ Storage::url($image->path) }}"
                                                        alt="">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <img class="rounded-lg-3" src="{{ Storage::url($section_1->content->image) }}"
                                    alt="">
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="display-4 fw-semibold lh-1 text-dark-dark">
                            {{ $section_1->title }}
                        </h1>
                        <div class="lead text-dark-light fw-normal my-3 pt-3 pe-3 pb-3 rounded-lg">
                            {!! $section_1->content->description !!}
                        </div>
                        <div class="d-grid gap-2 d-lg-flex justify-content-lg-start">
                            @foreach ($section_1->buttons as $button)
                                @component('front.components.link',
                                    [
                                        'url' => $button->url,
                                        'variant' => $button->style,
                                        'size' => 'large',
                                        'target' => $button->target,
                                        'title' => $button->title,
                                        'iconTag' => $button->icon,
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
    @endif

    @if ($section_2)
        @component('front.components.sections.default',
            [
                'section' => $section_2,
                'alignment' => 'right',
            ])
        @endcomponent
    @endif

    @if ($section_3)
        @component('front.components.sections.default',
            [
                'section' => $section_3,
                'alignment' => 'left',
            ])
        @endcomponent
    @endif
@endsection
