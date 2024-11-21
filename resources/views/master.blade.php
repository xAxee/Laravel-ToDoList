<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToDo - WebApp </title>
    <link rel="icon" href="{{ asset('css/favicon.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://kit.fontawesome.com/fa409bfd1c.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-primary text-light">
        <a href="{{ route('home') }}"><span class="navbar-brand mb-0 h1 text-light">ToDo App</span></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                @auth
                    @if (Route::is('todo') || Route::is('group.list'))
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#createModal">Utwórz grupe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#chartModal">Wykres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#createModal">Dodaj zadanie</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#createModal">Utwórz grupe</a>
                        </li>
                    @endif
                @endauth
            </ul>
            @auth
                <ul class="navbar-nav">
                    <div class="nav-item dropdown dropleft">
                        <a class="dropdown-toggle" id="dropdown_logOut" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">{{ Auth::user()->name }}</a>

                        <div class="dropdown-menu" aria-labelledby="dropdown_logOut">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Wyloguj się
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </ul>
            @endauth
        </div>
    </nav>

    <div class="container mt-3">

        @include('alerts')

        @yield('content')
        <!-- Modals -->
        <div>
            @yield('modals')
        </div>
    </div>

</body>

@yield('scripts')
@yield('styles')

</html>
