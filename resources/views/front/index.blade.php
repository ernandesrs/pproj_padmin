@extends('layouts.front')

@section('content')
    <div class="container-fluid">
        <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3">
            <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                <a class="d-block py-3" href="">
                    <img class="img-fluid" src="{{ asset('assets/img/padmin_demo_logo.svg') }}" alt="">
                </a>
                <h1 class="display-4 fw-semibold lh-1 mb-4 text-dark-dark">
                    Bem vindo ao live preview do PADMIN!
                </h1>
                <p class="lead text-dark-light fw-normal pb-3">
                    PADMIN é um painel administrativo construído utilizando Vue JS 3 com
                    Inertia JS. Ele possui toda a parte de autenticação, cadastro e gerenciamento
                    de usuário, páginas e imagens.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                    @guest
                        <a href="{{ route('auth.login') }}" class="btn btn-outline-primary btn-lg px-4 me-md-2 fw-bold">Acessar
                            painel</a>
                    @else
                        <a href="{{ route('admin.index') }}" class="btn btn-outline-primary btn-lg px-4 me-md-2 fw-bold">Acessar
                            painel</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden">
                <img class="rounded-lg-3" src="{{ asset('assets/img/padmin_preview.png') }}" width="525" alt="">
            </div>
        </div>
    </div>
@endsection
