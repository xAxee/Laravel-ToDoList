<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="assignModalLabel">
                    <i class="fas fa-user-plus"></i> Przypisz osobę do zadania
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="assign-form" method="GET">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                    <div class="form-group">
                        <label>
                            <i class="fas fa-users"></i> Wybierz osobę
                        </label>
                        <select class="custom-select" id="users" name="email"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="todo_id" id="assign_id" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Zamknij
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-user-check"></i> Przypisz
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
