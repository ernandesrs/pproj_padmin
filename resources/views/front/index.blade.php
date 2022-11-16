@extends('layouts.front')

@section('content')
    @if ($section_1)
        <div class="container py-5">
            <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3">
                <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                    <h1 class="display-4 fw-semibold lh-1 mb-4 text-dark-dark">
                        {{ $section_1->title }}
                    </h1>
                    <div class="lead text-dark-light fw-normal pb-3">
                        {!! $section_1->content->description !!}
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                        @foreach ($section_1->buttons as $button)
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
                </div>
                <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden">
                    <img class="rounded-lg-3" src="{{ Storage::url($section_1->content->image) }}" width="525"
                        alt="">
                </div>
            </div>
        </div>
    @endif

    @if ($section_2)
        <div class="container py-5">
            <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3">
                <div class="col-lg-4 p-0">
                    <img class="img-fluid rounded-lg-3" src="{{ Storage::url($section_2->content->image) }}" width="525"
                        alt="">
                </div>
                <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                    <h1 class="display-4 fw-semibold lh-1 text-dark-dark">
                        {{ $section_2->title }}
                    </h1>
                    <h2>
                        {{ $section_2->subtitle }}
                    </h2>
                    <p class="lead text-dark-light fw-normal pb-3">
                        {!! $section_2->content->content !!}
                    </p>
                    <div class="pt-2">
                        @foreach ($section_2->buttons as $button)
                            <a href="{{ $button->url }}"
                                class="btn btn-{{ $button->style }} btn-lg px-4 me-md-2 fw-semibold"
                                target="{{ $button->target }}" title="{{ $button->title }}">
                                @if (($button->align ?? 'start') == 'start')
                                    {!! $button->icon !!} <span>{{ $button->text }}</span>
                                @else
                                    <span>{{ $button->text }}</span> {!! $button->icon !!}
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($section_3)
        <div class="container py-5">
            <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3">
                <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                    <h1 class="display-4 fw-semibold lh-1 text-dark-dark">
                        {{ $section_3->title }}
                    </h1>
                    <h2>
                        {{ $section_3->subtitle }}
                    </h2>
                    <p class="lead text-dark-light fw-normal pb-3">
                        {!! $section_3->content->content !!}
                    </p>
                    <div class="pt-2">
                        @foreach ($section_3->buttons as $button)
                            <a href="{{ $button->url }}"
                                class="btn btn-{{ $button->style }} btn-lg px-4 me-md-2 fw-semibold"
                                target="{{ $button->target }}" title="{{ $button->title }}">
                                @if (($button->align ?? 'start') == 'start')
                                    {!! $button->icon !!} <span>{{ $button->text }}</span>
                                @else
                                    <span>{{ $button->text }}</span> {!! $button->icon !!}
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <img class="img-fluid rounded-lg-3" src="{{ Storage::url($section_3->content->image) }}" width="525"
                        alt="">
                </div>
            </div>
        </div>
    @endif
@endsection
