@extends('layouts.front')

@section('content')
    @php
        $alignments = ['left', 'right', 'center', 'left'];
    @endphp
    @foreach ($sections ?? [] as $key => $section)
        @if (in_array($section->type, [
            \App\Models\Section\Section::TYPE_BANNER,
            \App\Models\Section\Section::TYPE_BANNER_IMAGES,
        ]))
            @component('front.components.sections.banner',
                [
                    'section' => $section,
                    'alignment' => $alignments[$key],
                ])
            @endcomponent
        @elseif(in_array($section->type, [
            \App\Models\Section\Section::TYPE_DEFAULT,
            \App\Models\Section\Section::TYPE_DEFAULT_IMAGES,
        ]))
            @component('front.components.sections.default',
                [
                    'section' => $section,
                    'alignment' => $alignments[$key],
                ])
            @endcomponent
        @elseif(in_array($section->type, [\App\Models\Section\Section::TYPE_BOUND]))
            @component('front.components.sections.items',
                [
                    'section' => $section,
                    'items' => $section->bindables() ?? [],
                    'alignment' => $alignments[$key],
                ])
            @endcomponent
        @endif
    @endforeach
@endsection
