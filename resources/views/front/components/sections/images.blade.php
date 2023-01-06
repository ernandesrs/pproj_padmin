<div class="section-{{ $image ?? false ? 'image' : 'images' }} d-flex align-items-center">
    @component('front.components.slides.images',
        [
            'images' => $images,
            'slideOptions' => $slideOptions ?? null,
        ])
    @endcomponent
</div>
