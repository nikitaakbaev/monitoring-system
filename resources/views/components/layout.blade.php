<!doctype html>
<html lang="ru" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">

</head>
<body class="h-100 d-flex flex-column">
<header>
    <nav class="navbar navbar-expand-lg border-bottom border-body">
        <div class="container">
            <a class="navbar-brand" href="{{Route('home')}}">Система Мониторинга</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('login')) active text-decoration-underline @endif" href="{{Route('login')}}">Авторизация</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('home')) active text-decoration-underline @endif" aria-current="page" href="{{Route('home')}}">Главная страница</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('profileUser')) active text-decoration-underline @endif" href="{{Route('profileUser')}}">{{Auth::user() -> middle_name}}</a>
                        </li>
                        @if (Auth::user()->roleID == 1)
                            <li class="nav-item">
                                <a class="nav-link @if(Route::is('admin.dashboard')) active text-decoration-underline @endif" href="{{ route('admin.dashboard') }}">Админ</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link @if(Route::is('createUser')) active text-decoration-underline @endif" href="{{Route('createUser')}}">Добавить пользователя</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{Route('logout')}}">Выйти</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="flex-grow-1 container">
    {{$slot}}
</main>
<footer></footer>
<script src="{{asset('assets/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}',
        routes: {
            createUser: '{{ route("createUserAccount") }}',
        }
    };
</script>
</body>
</html>
