<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - {{ $pageTitle }}</title>
    @if ($favicon = $settings->content->header->favicon)
        <link rel="shortcut icon" href="{{ Storage::url($favicon) }}" type="image/x-icon">
    @endif
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/app.css') }}">
</head>

<body>
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        @if ($settings->content->header->logo ?? null)
                            <img class="img-fluid" src="{{ Storage::url($settings->content->header->logo) }}"
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
                            <ul class="navbar-nav ms-auto">
                                @foreach ($menu_main->items as $menuItem)
                                    <li class="nav-item">
                                        <a href="{{ $menuItem->url }}" target="{{ $menuItem->target }}"
                                            title="{{ $menuItem->title }}" class="nav-link">
                                            {!! $menuItem->icon !!} {{ $menuItem->text }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main class="main">
        @yield('content')
    </main>
    <footer class="footer py-3 text-center">
        <div class="container">
            <small>
                {{ config('app.name') }} &copy; {{ date('Y') }} - Por <a href="https://github.com/ernandesrs"
                    title="Perfil no Github" target="_blank">Ernandes R Souza</a>
            </small>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
