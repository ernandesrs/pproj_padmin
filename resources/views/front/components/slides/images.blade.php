@component('front.components.slides.base',
    [
        'transitionSpeed' => 750,
        'ariaLabel' => '',
        'slideOptions' => $slideOptions,
    ])
    @slot('slotItems')
        @foreach ($images as $key => $image)
            @component('front.components.slides.item',
                [
                    'interval' => $image->duration ?? 3500,
                ])
                @slot('slotItem')
                    <img src="{{ Storage::url($image->path) }}" alt="Slide #{{ $key }}">
                @endslot
            @endcomponent
        @endforeach
    @endslot
@endcomponent
