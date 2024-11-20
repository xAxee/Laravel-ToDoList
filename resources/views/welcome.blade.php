@extends('master')
@section('content')
    <div class="text-light text-center">
        <h1 class="mt-5">ToDo App</h1>
        <p>Aplikacja do zarządzania zadaniami</p>
        @if (Route::has('login'))
            <div class="mt-5">
                @auth
                    <a href="{{ route('todo') }}" class="btn btn-success">
                        <i class="fas fa-user"></i> Przejdź do prywatnej listy zadań
                    </a>
                    <a href="{{ route('group') }}" class="btn btn-secondary">
                        <i class="fas fa-users"></i> Przejdź do grupowych list zadań
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success">Zaloguj się</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Zarejestruj się</a>
            @endif
        </div>
        @endif
        </div>
    @endsection
