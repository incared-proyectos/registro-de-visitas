<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de visitas</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{!! asset('css/landing.css') !!}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,500,700&display=swap" rel="stylesheet">
        <link href="{{ asset('plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>

        <div class="container-fluid header-nav">
            <div class="container">
                <div class="row">
                    <div class="col-4 logo-nav">
                        <img src="{!! asset('img/landing/logo2.jpg') !!}" class="logo-header" alt="">
                    </div>
                    <div class="col-8 nav-nav text-right text-uppercase p-2">
                        @if (Route::has('login'))
                            @auth
                                <a class="link-nav" href="{{ url('/home') }}">Inicio</a>
                            @else
                                <a class="link-nav" href="{{ route('login') }}">Iniciar Sesion</a>

                                @if (Route::has('register'))
                                    <a class="link-nav"  href="{{ route('register') }}">Registrar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="section-two">
            <div class="letter-text" >
                <div class="container">
                    <div class="row  align-items-center">
                        <div class="col-6">
                            <h3 class="entry-text">Que contiene nuestro sistema?</h3>
                            <p class="text-pert"><i class="far fa-check-circle"></i> Registro de visita</p>
                            <p class="text-pert"><i class="far fa-check-circle"></i> Capture de la visita</p>
                            <p class="text-pert"><i class="far fa-check-circle"></i> Herramientas</p>
                            <p class="text-pert"><i class="far fa-check-circle"></i> Entidades</p>
                        </div>
                        <div class="col-6">
                            <img src="{!! asset('img/landing/financiero2.png') !!}" class="imgl" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-medium">
            <hr>
            <h2 class="text-center p-2"><i class="icon-wave2"></i> Rapido, estable y confiable</h2>
            <hr>
        </div>
        <div class="section-three">
            <div class="container">
                <br>
                <br>
                <h3 class="text-center head-b"><i class="icon-pulse2"></i> Funcionalidades</h3>
                <hr>
                <div class="row">
                    <div class="col-3 text-center ">
                        <div class="cort-fart">
                            <i class="fas fa-shopping-cart ico-head"></i>
                            <hr>
                            <p class="box-landing-text"><i class="fas fa-atom"></i> Registro de visita rapido</p>
                        </div>

                    </div>
                    <div class="col-3 text-center">
                          <div class="cort-fart">
                            <i class="fas fa-camera ico-head"></i>
                            <hr>
                            <p class="box-landing-text"><i class="fas fa-atom"></i> Captura de manera sencilla</p>

                        </div>
                    </div>
                    <div class="col-3 text-center ">
                          <div class="cort-fart">
                            <i class="fas fa-cog ico-head"></i>
                            <hr>
                            <p class="box-landing-text"><i class="fas fa-atom"></i> Uso de api configurable</p>
                        </div>
                    </div>
                    <div class="col-3 text-center ">
                          <div class="cort-fart">
                            <i class="fas fa-clipboard-check ico-head"></i>
                            <hr>
                            <p class="box-landing-text"><i class="fas fa-atom"></i> Sistema facil de entender</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <p class="text-footer text-center"> Todos los derechos reservados Incared 2019-2020</p>
        </footer>
    </body>
</html>
