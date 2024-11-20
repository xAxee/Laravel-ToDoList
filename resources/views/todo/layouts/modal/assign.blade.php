<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Przypisz osobe do zadania</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="assign-form">
                <div class="modal-body">
                    <label>Wybierz osobe</label>
                    <select class="custom-select" id="users" name="email"></select>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="todo_id" id="assign_id" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    <button type="submit" class="modal-form btn btn-info">Przypisz</button>
                </div>
            </form>
        </div>
    </div>
</div>
