@extends('layouts.front')

@section('content')
    @php
        $sections = $page->sections;
        $sections_settings = $page->sections_settings;
        $key = 0;
    @endphp

    @foreach ($sections_settings ?? [] as $setting_section)
        @php
            $section = $sections->where('id', $setting_section->id)->first();
        @endphp

        @if ($section)
            @if (in_array($section->type, [\App\Models\Section\Section::TYPE_BANNER]))
                @component('front.components.sections.banner',
                    [
                        'section' => $section,
                        'alignment' => $setting_section->alignment,
                    ])
                @endcomponent
            @elseif(in_array($section->type, [\App\Models\Section\Section::TYPE_DEFAULT]))
                @component('front.components.sections.default',
                    [
                        'section' => $section,
                        'alignment' => $setting_section->alignment,
                    ])
                @endcomponent
            @elseif(in_array($section->type, [\App\Models\Section\Section::TYPE_BINDABLE]))
                @component('front.components.sections.cards-list',
                    [
                        'section' => $section,
                        'items' => $section->bindables() ?? [],
                        'alignment' => $setting_section->alignment,
                    ])
                @endcomponent
            @endif
        @endif

        @php
            $key++;
        @endphp
    @endforeach
@endsection
