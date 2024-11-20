@extends('master')

@section('content')

    @if ($groups->count() == 0)
        <div class='text-light text-center'>
            <h3>Nie masz żadnych grup</h3>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal"
                data-status="todo">Utwórz nową grupę</button>
        </div>
    @else
        <div class='text-light mb-3'>
            <h2 class="text-center">
                <a href="{{ route('home') }}"><button class="btn btn-secondary text-light"><i
                            class="fas fa-chevron-double-left"></i></button></a>
                Lista grup
            </h2>
            <hr style="border: 1px solid #6c757d;">
        </div>
        <!-- Group list -->
        <div class="row">
            @foreach ($groups as $group)
                @include('group.layouts.group')
            @endforeach
        </div>
    @endif
    @if ($groups->count() != 0)
        <div class="text-center mt-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">Utwórz nowa grupę</button>
        </div>
    @endif
@endsection

@section('modals')
    @include('group.layouts.modal.create')
    @include('group.layouts.modal.invite')
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

        $('#inviteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('link')
            document.getElementById('invite-link').value = window.location.href + "/invite/" + value;
        })

        $('#createModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
        })

        function copyInvite() {
            var copyText = document.getElementById("invite-link");
            copyText.select();
            navigator.clipboard.writeText(copyText.value);
        }
    </script>
@endsection
