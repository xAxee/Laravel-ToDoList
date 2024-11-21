@extends('master')

@section('content')
    <!-- Title -->
    <div class='text-light mb-5'>
        <h2 class="text-center">
            <a href="{{ route('group') }}"><button class="btn btn-secondary text-light"><i
                        class="fas fa-chevron-double-left"></i></button></a>
            {{ $group->name }}
        </h2>
        <hr style="border: 1px solid #6c757d;">
    </div>
    <!-- Container -->
    <div class="container">
        @if ($count == 0)
            <!-- No todos -->
            <div class='text-light text-center'>
                <h3>Nie masz żadnych zadań</h3>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal"
                    data-status="todo"><i class="fas fa-plus"></i> Dodaj zadanie</button>
            </div>
        @else
            <!-- Todos list header -->
            <div class="row mt-2 text-light">
                <div class="col-sm">
                    <h3>Do zrobienia <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#createModal" data-status="1"><i class="fas fa-plus"></i></button></h3>
                </div>
                <div class="col-sm">
                    <h3>W trakcie <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#createModal" data-status="2"><i class="fas fa-plus"></i></button></h3>
                </div>
                <div class="col-sm">
                    <h3>Ukonczone <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#createModal" data-status="3"><i class="fas fa-plus"></i></button></h3>
                </div>
            </div>
            <!-- Todos list -->
            <div class="row">
                <!-- todo list -->
                <div class="col-sm" dropzone="true">
                    @foreach ($first as $item)
                        @include('todo.layouts.task')
                    @endforeach
                </div>
                <!-- in progress -->
                <div class="col-sm">
                    @foreach ($second as $item)
                        @include('todo.layouts.task')
                    @endforeach
                </div>
                <!-- Finish -->
                <div class="col-sm">
                    @foreach ($third as $item)
                        @include('todo.layouts.task')
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
@section('modals')
    @include('todo.layouts.modal.create')
    @include('todo.layouts.modal.delete')
    @include('todo.layouts.modal.edit')
    @include('todo.layouts.modal.info')
    @include('todo.layouts.modal.chart')
    @include('todo.layouts.modal.assign')
@endsection

@section('scripts')
    <script>
        /* Bootstrap validation */

        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        /* Bootstrap delete modal */

        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('id')
            document.getElementById('delete-form').action = "/todo/post/delete/" + value;
        })

        /* Bootstrap assign modal */

        $('#assignModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('id')
            var asigned = button.data('asigned')
            document.getElementById('users').innerHTML = ""
            var usersList = {{ Illuminate\Support\Js::from($group->users()) }};
            usersList.unshift({
                'email': 'Nikt',
                'name': 'Nikt'
            });
            usersList.forEach((e) => {
                var option = document.createElement('option');
                if (e.email == asigned) {
                    option.selected = true;
                }
                option.value = e.email;
                option.innerText = e.name;
                document.getElementById('users').appendChild(option);
            })
            document.getElementById("assign_id").value = value;
            document.getElementById('assign-form').action = "/group/" + {{ $group->id }} + "/post/assign";
        })

        /* Bootstrap create modal */

        $('#createModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('status')
            var options = document.getElementById('status').children;
            for (let e of options) {
                if (e.value == value) {
                    e.selected = true;
                }
            }
        })

        /* Bootstrap edit modal */

        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var title = button.data('title')
            var id = button.data('id')
            var description = button.data('description')
            var status = button.data('status')
            document.getElementById('edit-title').value = title
            document.getElementById('edit-description').value = description
            var options = document.getElementById('edit-status').children;
            var form = document.getElementById('editForm');
            for (let e of options) {
                if (e.value == status) {
                    e.selected = true;
                }
            }
            form.action = "/todo/post/edit/" + id;
        })

        /* Bootstrap info modal */

        $('#infoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var description = button.data('description')
            var status = button.data('status')
            var who = button.data('who') ? 'Dodał: <b>' + button.data('who') + '</b>' : '';
            var assign = button.data('assign') ? '<br>Przypisano do: <b>' + button.data('assign') + '</b>' : '';
            var date = button.data('date') ? '<br>Utworzono: <b>' + button.data('date') + '</b>' : '';
            document.getElementById('infoModal-id').innerHTML = id
            document.getElementById('infoModal-title').innerHTML = "Tytul: " + title
            document.getElementById('infoModal-description').innerText = description
            document.getElementById('infoModal-who').innerHTML = who + ", " + assign + ", " + date;
            document.getElementById('infoModal-status').innerHTML = (status == 1) ? "Do zrobienia" : (
                    status == 2) ?
                "W trakcie" : "Ukonczone";
        })

        /* Progress chart */

        var xValues = ["Do zrobienia", "W trakcie", "Ukonczone"];
        var yValues = [{{ $first->count() }}, {{ $second->count() }}, {{ $third->count() }}];
        var barColors = ["#dc3545", "#ffc107", "#28a745"];

        new Chart("myChart", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            }
        });
    </script>
@endsection
