@extends('layouts.front')

@section('content')
    <div class="container-fluid">
        <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3">
            <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                <div class="d-flex align-items-center">
                    <a class="d-block py-3" href="">
                        @if ($settings->content->header->logo ?? null)
                            <img class="img-fluid" src="{{ Storage::url($settings->content->header->logo) }}" alt="">
                        @else
                            {{ config('app.name') }}
                        @endif
                    </a>

                    @if ($menu_main)
                        <nav class="ms-auto nav">
                            @foreach ($menu_main->items as $menuItem)
                                <a href="{{ $menuItem->url }}" target="{{ $menuItem->target }}"
                                    title="{{ $menuItem->title }}" class="nav-link">
                                    {!! $menuItem->icon !!} {{ $menuItem->text }}
                                </a>
                            @endforeach
                        </nav>
                    @endif
                </div>
                <h1 class="display-4 fw-semibold lh-1 mb-4 text-dark-dark">
                    Bem vindo ao live preview do PADMIN!
                </h1>
                <p class="lead text-dark-light fw-normal pb-3">
                    PADMIN é um painel administrativo construído utilizando Vue JS 3 com
                    Inertia JS e Bootstrap 5 com SASS no front; e Laravel 8 no backend. Ele possui toda a parte de
                    autenticação, cadastro e gerenciamento
                    de usuário, páginas e imagens.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                    @guest
                        <a href="{{ route('auth.login') }}" class="btn btn-outline-primary btn-lg px-4 me-md-2 fw-bold">
                            {{ Icons::render('login') }} Acessar painel
                        </a>
                    @else
                        <a href="{{ route('admin.index') }}" class="btn btn-outline-primary btn-lg px-4 me-md-2 fw-bold">
                            {{ Icons::render('pieChart') }} Acessar painel
                        </a>
                    @endguest
                    <a href="https://github.com/ernandesrs/pproj_padmin" target="_blank"
                        class="btn btn-lg btn-link px-4 me-md-2 fw-semibold border-0 text-decoration-none">
                        Ver no github {{ Icons::render('arrowRight') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden">
                <img class="rounded-lg-3" src="{{ asset('assets/img/padmin_preview.png') }}" width="525" alt="">
            </div>
        </div>
    </div>
@endsection
