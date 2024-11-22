@extends('master')

@section('content')
    <!-- Title -->
    <div class='text-light mb-5'>
        <h2 class="text-center">
            <a href="{{ route('group') }}">
                <button class="btn btn-secondary text-light">
                    <i class="fas fa-backward"></i>
                </button>
            </a>
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
                    data-status="{{ App\Models\Todo::STATUS_TODO }}">
                    <i class="fas fa-plus"></i> Dodaj zadanie
                </button>
            </div>
        @else
            <!-- Todos list header -->
            <div class="row mt-2 text-light">
                <div class="col-sm">
                    <h3>Do zrobienia 
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#createModal" data-status="{{ App\Models\Todo::STATUS_TODO }}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </h3>
                </div>
                <div class="col-sm">
                    <h3>W trakcie 
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#createModal" data-status="{{ App\Models\Todo::STATUS_IN_PROGRESS }}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </h3>
                </div>
                <div class="col-sm">
                    <h3>Ukończone 
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#createModal" data-status="{{ App\Models\Todo::STATUS_DONE }}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </h3>
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
            var title = button.data('title')
            document.getElementById('delete-form').action = "/todo/post/delete/" + value;
            document.getElementById('delete-task-title').textContent = title;
        })

        /* Bootstrap assign modal */
        $('#assignModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('id')
            var assigned = button.data('assigned')
            var title = button.data('title')

            // Resetowanie selecta
            document.getElementById('users').innerHTML = ""
            
            // Przygotowanie listy użytkowników
            var usersList = {{ Illuminate\Support\Js::from($group->getAllUsers()) }};
            usersList.unshift({
                'email': '',
                'name': 'Nikt'
            });

            // Wypełnianie selecta
            usersList.forEach((user) => {
                var option = document.createElement('option');
                option.value = user.email;
                option.textContent = user.name;
                option.selected = user.email === assigned;
                document.getElementById('users').appendChild(option);
            });

            // Ustawianie ID zadania i akcji formularza
            document.getElementById("assign_id").value = value;
            document.getElementById('assign-form').action = "/todo/assign/" + {{ $group->id }};
        })

        /* Bootstrap create modal */
        $('#createModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('status')

            // Czyszczenie formularza
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            document.getElementById('assign').value = '';

            // Ustawianie statusu
            var options = document.getElementById('status').children;
            Array.from(options).forEach(option => {
                option.selected = option.value == value;
            });

            // Resetowanie walidacji
            var form = document.querySelector('#createModal form');
            form.classList.remove('was-validated');
        })

        /* Bootstrap edit modal */
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var description = button.data('description')
            var status = button.data('status')
            var assigned = button.data('assigned')

            // Wypełnianie formularza
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-description').value = description;

            // Ustawianie statusu
            var statusOptions = document.getElementById('edit-status').children;
            Array.from(statusOptions).forEach(option => {
                option.selected = option.value == status;
            });

            // Ustawianie przypisanej osoby
            var assignSelect = document.getElementById('assignEdit');

            if(assignSelect){
                // Resetowanie selecta
                assignSelect.innerHTML = ""
                
                // Przygotowanie listy użytkowników
                var usersList = {{ Illuminate\Support\Js::from($group->getAllUsers()) }};
                usersList.unshift({
                    'email': '',
                    'name': 'Nikt'
                });

                // Wypełnianie selecta
                usersList.forEach((user) => {
                    var option = document.createElement('option');
                    option.value = user.email;
                    option.textContent = user.name;
                    option.selected = user.email == assigned;
                    assignSelect.appendChild(option);
                });
            }

            // Ustawianie akcji formularza
            document.getElementById('editForm').action = "/todo/post/edit/" + id;

            // Resetowanie walidacji
            document.getElementById('editForm').classList.remove('was-validated');
        })

        /* Bootstrap info modal */
        $('#infoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var title = button.data('title')
            var description = button.data('description')
            var status = button.data('status')
            var who = button.data('who')
            var assign = button.data('assign')
            var created = button.data('date')
            var updated = button.data('updated')

            // Ustawianie podstawowych informacji
            document.getElementById('infoModal-id').textContent = id;
            document.getElementById('infoModal-title').textContent = title;
            document.getElementById('infoModal-description').textContent = description;

            // Ustawianie informacji o osobach
            var whoText = [];
            if (who) whoText.push('Dodał: ' + who);
            if (assign) whoText.push('Przypisano do: ' + assign);
            document.getElementById('infoModal-who').innerHTML = whoText.join('<br>');

            // Ustawianie dat
            if (created) document.getElementById('infoModal-created').textContent = created;
            if (updated) document.getElementById('infoModal-updated').textContent = updated;

            // Ustawianie statusu
            const statusMap = {
                {{ App\Models\Todo::STATUS_TODO }}: "Do zrobienia",
                {{ App\Models\Todo::STATUS_IN_PROGRESS }}: "W trakcie",
                {{ App\Models\Todo::STATUS_DONE }}: "Ukończone"
            };
            var statusText = statusMap[status] || "Nieznany status";

            // Ustawianie badge'a statusu
            var statusBadge = document.getElementById('infoModal-status-badge');
            statusBadge.textContent = statusText;
            statusBadge.className = 'badge badge-pill status-' + status;
        })

        /* Progress chart */
        var xValues = ["Do zrobienia", "W trakcie", "Ukończone"];
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
