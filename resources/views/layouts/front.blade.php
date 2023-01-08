@php
    $menu_main = $settings->content->header->menu_main;
@endphp

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - {{ $pageTitle }}</title>
    @if ($favicon = $settings->content->header->favicon->path_url)
        <link rel="shortcut icon" href="{{ Storage::url($favicon) }}" type="image/x-icon">
    @endif
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{ asset('css/front/app.css') }}">
</head>

<body>
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        @if ($logo = $settings->content->header->logo->path_url ?? null)
                            <img class="img-fluid" src="{{ Storage::url($logo) }}"
                                alt="">
                        @else
                            {{ config('app.name') }}
                        @endif
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#headerMainNav" aria-controls="headerMainNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="headerMainNav">
                        @if ($menu_main)
                            @component('front.components.nav',
                                [
                                    'items' => $menu_main->items,
                                    'customClass' => 'ms-auto',
                                    'vertical' => false,
                                ])
                            @endcomponent
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer py-4 text-center">
        <div class="container">
            @if ($settings->content->socials ?? null)
                <div class="pb-3">
                    @php
                        $urls = [
                            'facebook' => 'https://facebook.com/',
                            'instagram' => 'https://instagram.com/',
                            'twitter' => 'https://twitter.com/',
                            'github' => 'https://github.com/',
                            'linkedin' => 'https://linkedin.com/in/',
                            'youtube' => 'https://youtube.com/@',
                            'tiktok' => 'https://tiktok.com/@',
                        ];
                    @endphp

                    <ul class="nav justify-content-center fs-5">
                        @foreach ($settings->content->socials as $key => $social)
                            @if ($social)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $urls[$key] ?? null }}{{ $social }}"
                                        title="{{ ucfirst($key) }}" target="_blank">
                                        {!! Icons::elem($key) !!}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <small>
                    {{ config('app.name') }} &copy; {{ date('Y') }} - Por <a href="https://github.com/ernandesrs"
                        title="Perfil no Github" target="_blank">Ernandes R Souza</a>
                </small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <script>
        let splidesDefault = document.querySelectorAll('.jsSplideDefault');

        if (splidesDefault.length) {
            for (var i = 0; i < splidesDefault.length; i++) {
                let options = splidesDefault[i].getAttribute('data-options');

                new Splide(splidesDefault[i], JSON.parse(options)).mount();
            }
        }
    </script>

    <script src="{{ asset('js/bootstrap.js') }}"></script>

    @yield('scripts')
</body>

</html>
