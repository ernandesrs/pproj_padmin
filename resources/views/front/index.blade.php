@extends('layouts.front')

@section('content')
    @php
        $alignments = ['left', 'right', 'center', 'left'];
        $key = 0;
    @endphp
    @foreach ($home_sections ?? [] as $section)
        @if ($section)
            @if (in_array($section->type, [
                \App\Models\Section\Section::TYPE_BANNER
            ]))
                @component('front.components.sections.banner',
                    [
                        'section' => $section,
                        'alignment' => $alignments[$key],
                    ])
                @endcomponent
            @elseif(in_array($section->type, [
                \App\Models\Section\Section::TYPE_DEFAULT,
            ]))
                @component('front.components.sections.default',
                    [
                        'section' => $section,
                        'alignment' => $alignments[$key],
                    ])
                @endcomponent
            @elseif(in_array($section->type, [\App\Models\Section\Section::TYPE_BINDABLE]))
                @component('front.components.sections.cards-list',
                    [
                        'section' => $section,
                        'items' => $section->bindables() ?? [],
                        'alignment' => $alignments[$key],
                    ])
                @endcomponent
            @endif
        @endif

        @php
            $key++;
        @endphp
    @endforeach
@endsection
