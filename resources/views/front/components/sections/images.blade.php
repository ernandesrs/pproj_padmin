<div class="section-{{ $image ?? false ? 'image' : 'images' }} d-flex align-items-center">
    @if ($image ?? false)
        <img class="img-fluid" src="{{ Storage::url($image) }}" alt="">
    @elseif($images ?? false)
        @component('front.components.slides.images',
            [
                'images' => $images,
                'slideOptions' => $slideOptions ?? null,
            ])
        @endcomponent
    @endif
</div>
