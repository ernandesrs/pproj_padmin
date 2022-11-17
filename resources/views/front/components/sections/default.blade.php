<section class="section default-section {{ $alignment }}-section">
    <div class="container">
        <div class="row justify-content-center justify-content-lg-start align-items-center">
            <div
                class="col-lg-6 {{ ($alignment ?? 'left') == 'right' ? 'order-lg-5' : '' }} d-flex justify-content-center mb-4 mb-lg-0">
                @component('front.components.sections.images',
                    [
                        $section->content->image ?? null ? 'image' : 'images' =>
                            $section->content->image ?? ($section->content->images ?? []),
                    ])
                @endcomponent
            </div>

            <div class="col-lg-6 text-center text-lg-start {{ ($alignment ?? 'left') == 'right' ? 'order-lg-1' : '' }}">
                @component('front.components.sections.content',
                    [
                        'title' => $section->title,
                        'subtitle' => $section->subtitle,
                        'content' => $section->content,
                        'buttons' => $section->buttons,
                    ])
                @endcomponent
            </div>
        </div>
    </div>
</section>
