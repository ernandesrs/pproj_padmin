@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 text-center text-md-start">
                A
            </div>
            <div class="col-12 col-md-6 text-center text-md-start">
                <a href="{{ route('front.index') }}">
                    <img src="{{ asset('assets/img/padmin_demo_logo.svg') }}" alt="">
                </a>
                <h1 class="fs-4 fw-semibold text-dark mb-0 py-3">
                    Bem vindo ao live preview do PADMIN
                </h1>
                <div class="fs-6 fw-semibold text-dark-light">
                    <p>
                        PADMIN é um painel administrativo construído utilizando Vue JS 3 com
                        Inertia JS. Ele possui toda a parte de autenticação, cadastro e gerenciamento
                        de usuário, páginas e imagens.
                    </p>
                    <p>
                        Você pode acessar e navegar pelas páginas do painel como um visitante,
                        para isso clique no botão <span class="text-primary">Fazer login</span> abaixo e faça login com
                        as
                        credenciais pré-inseridas no formulário de login.
                    </p>
                </div>

                @guest
                    <a class="btn btn-primary" href="{{ route('auth.login') }}" title="Fazer login">
                        Fazer login
                    </a>
                @else
                    <a class="btn btn-primary" href="{{ route('admin.index') }}" title="Acessar o painel">
                        Acessar o painel
                    </a>
                @endguest
            </div>
        </div>
    </div>
@endsection
