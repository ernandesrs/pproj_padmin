<div class="section-{{ $image ?? false ? 'image' : 'images' }} d-flex align-items-center">
    @if ($image ?? false)
        <img class="img-fluid" src="{{ Storage::url($image) }}" alt="">
    @elseif($images ?? false)
        @foreach ($images as $image)
            <img class="img-fluid" src="{{ Storage::url($image) }}" alt="">
        @endforeach
    @endif
</div>
