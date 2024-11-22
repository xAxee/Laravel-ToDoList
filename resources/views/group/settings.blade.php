@extends('master')

@section('content')
    <div class="text-center text-light">
        <h2>
            <a href="{{ route('group') }}"><button class="btn btn-secondary text-light"><i class="fa-solid fa-backward"></i></button></a>
            <span>Ustawienia grupy</span>
        </h2>
        <hr style="border: 1px solid #6c757d;">
    </div>
    <div class="mb-5 mt-4">
        <!-- Edit group -->
        <div class="card w-100 text-light task-card border-primary">
            <div class="card-body">
                <h5 class="card-title">Edytowanie informacji</h5>
                <form action="{{ route('group.post.edit', $group->id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-2 col-form-label" for="title">Nazwa</label>
                        <div class="col-10">
                            <input id="title" name="title" placeholder="Nazwa" type="text" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $group->name) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-2 col-form-label">Opis</label>
                        <div class="col-10">
                            <textarea id="description" name="description" style="min-height: 50px;" cols="40" rows="5"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $group->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-2 col-10">
                            <button name="submit" type="submit" class="btn btn-primary">Zapisz</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Delete group -->
        <div class="card w-100 text-light task-card border-danger mt-3">
            <div class="card-body">
                <h5 class="card-title">Usuwanie grupy</h5>
                <button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#deleteModal">Usuń
                    grupę</button>
            </div>
        </div>
        <!-- Add user -->
        <div class="card w-100 text-light task-card border-success mt-3">
            <div class="card-body">
                <h5 class="card-title">Dodawanie członka</h5>
                <form action="{{ route('group.user.add', $group->id) }}" class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <div class="autocomplete text-dark">
                            <input id="myInput" class="form-control @error('email') is-invalid @enderror" type="text" 
                                name="email" placeholder="Email" data-list="#myList" autocomplete="off" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <datalist id="myList">
                                @foreach ($allUsers as $user)
                                    <option value="{{ $user->email }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Dodaj</button>
                </form>
            </div>
        </div>
        <!-- Users table -->
        <div class="card mt-3 text-light task-card border-warning">
            <div class="card-body w-100">
                <h5 class="card-title">Zarządzanie członkami</h5>
                <table class="table table-dark bg-transparent text-light m-2 w-100">
                    <thead>
                        <tr>
                            <th>Lp.</th>
                            <th>Nazwa</th>
                            <th>Email</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $lp = 1; @endphp
                        @foreach ($group->getAllUsers() as $user)
                            <tr>
                                <th>{{ $lp }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($group->isOwner($user))
                                        <button class="btn btn-warning disabled">Właściciel</button>
                                    @else
                                        <div class="btn-group">
                                            <form action="{{ route('group.user.remove', $group->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input hidden name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-danger mr-2">Wyrzuć</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @php $lp++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('group') }}" class="btn btn-secondary">Wróć</a>
        </div>
        @include('group.layouts.modal.delete')
    </div>
@endsection

@section('scripts')
    <script>
        var list = $("#myInput").data("list");
        var users = []
        document.querySelector("#myList").childNodes.forEach(e => {
            if (e.value != null) {
                users.push(e.value);
            }
        })
        autocomplete(document.getElementById("myInput"), users);
    </script>
@endsection

@section('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font: 16px Arial;
        }

        .autocomplete {
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input[type=text] {
            background-color: #f1f1f1;
            width: 100%;
        }

        input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
            cursor: pointer;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
@endsection
