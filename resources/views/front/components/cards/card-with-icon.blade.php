<div class="card card-body border-0 h-100">
    <div class="d-flex flex-column justify-content-center align-items-center mb-3">
        <div class="icon fs-2 py-2 px-3 bg-secondary rounded-5 text-light">
            @component('front.components.icon',
                [
                    'icon' => $icon,
                ])
            @endcomponent
        </div>
        <div class="text-center">
            <h2 class="fs-4 fw-semibold mb-0 py-2">
                {{ $title }}
            </h2>
            <p class="fs-5">
                {!! $description !!}
            </p>
        </div>
    </div>
</div>
