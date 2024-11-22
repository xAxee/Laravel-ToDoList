@extends('master')

@section('content')
    @if ($groups->count() == 0)
        <div class='text-light text-center'>
            <h3>Nie masz żadnych grup</h3>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal"
                data-status="todo">
                <i class="fas fa-plus-circle"></i> Utwórz nową grupę
            </button>
        </div>
    @else
        <div class='text-light mb-3'>
            <h2 class="text-center">
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
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus-circle"></i> Utwórz nową grupę
            </button>
        </div>
    @endif
@endsection

@section('modals')
    @include('group.layouts.modal.create')
    @include('group.layouts.modal.invite')
    @include('group.layouts.modal.leave')
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

        /* Bootstrap invite modal */
        $('#inviteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var value = button.data('link')
            var inviteLink = window.location.href + "/invite/" + value;
            document.getElementById('invite-link').value = inviteLink;
        })

        /* Bootstrap leave modal */
        $('#leaveModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var group_id = button.data('groupid');
            document.getElementById('leave-form').action = "/group/" + group_id + "/post/removeUser";
        })

        /* Bootstrap create modal */
        $('#createModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            // Czyszczenie formularza
            document.getElementById('title').value = '';
            document.getElementById('description').value = '';
            // Usuwanie poprzedniej walidacji
            document.getElementById('title').classList.remove('is-invalid', 'is-valid');
            document.getElementById('description').classList.remove('is-invalid', 'is-valid');
        })

        /* Kopiowanie linku zaproszenia */
        function copyInvite() {
            var copyText = document.getElementById("invite-link");
            copyText.select();
            navigator.clipboard.writeText(copyText.value);
            
            // Opcjonalnie: Pokaż tooltip z potwierdzeniem
            var tooltip = document.createElement('div');
            tooltip.className = 'tooltip show';
            tooltip.style.position = 'fixed';
            tooltip.style.backgroundColor = '#28a745';
            tooltip.style.color = 'white';
            tooltip.style.padding = '5px 10px';
            tooltip.style.borderRadius = '3px';
            tooltip.style.zIndex = '9999';
            tooltip.innerHTML = 'Skopiowano!';
            
            document.body.appendChild(tooltip);
            
            // Pozycjonowanie tooltipa
            var button = document.querySelector('button[onclick="copyInvite()"]');
            var rect = button.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
            tooltip.style.left = (rect.left + (button.offsetWidth - tooltip.offsetWidth) / 2) + 'px';
            
            // Usuń tooltip po 2 sekundach
            setTimeout(function() {
                document.body.removeChild(tooltip);
            }, 2000);
        }
    </script>
@endsection
