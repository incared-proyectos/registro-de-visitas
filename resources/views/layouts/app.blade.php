<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <script>
        let base_path_vue_router = '' ;
        let base_path_asset = "{{ asset('') }}";
    </script>
    @if(!empty(Config::get('vueconfig.path')))
        <script>
            base_path_vue_router = "{{ Config::get('vueconfig.path') }}";
        </script>
    @endif

    <!--BYR-->
    @routes

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles ICONS FONTAWESOME -->
    <link href="{{ asset('plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @auth
        @include('template_parts.vue_config')
    @else
        @include('template_parts.php_config')
    @endauth




    <!--ROL BY USER-->
    <script>
      @auth
        window.rolbyuser = "{!! auth()->user()->getRoleNames()[0] !!}";
      @else
        window.rolbyuser = '';
      @endauth
    </script>
    <!--///END///-->

    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>
        // Validamos si existe los mensajes de session para cargar en una vista  y si es asi lo visualizamos
        // Esto es un intento para combinar las session flash de laravel con vuejs al recargar una pagina 
        if(!!document.getElementById("session_message")){

         setTimeout(function(){ document.getElementById("session_message").style.display = "none" }, 5000);
        }
    </script>
</body>
</html>
