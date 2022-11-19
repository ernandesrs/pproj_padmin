<div class="section-{{ $image ?? false ? 'image' : 'images' }} d-flex align-items-center">
    @if ($image ?? false)
        <img class="img-fluid" src="{{ Storage::url($image) }}" alt="">
    @elseif($images ?? false)
        <div class="splide jsSplideDefault" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($images ?? [] as $image)
                        <li class="splide__slide">
                            <img class="rounded-lg-3" src="{{ Storage::url($image->path) }}" alt="">
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
