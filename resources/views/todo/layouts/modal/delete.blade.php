<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash-alt"></i> Potwierdzenie usunięcia
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Uwaga! Ta operacja jest nieodwracalna.
                </div>
                <p class="mb-2">Czy na pewno chcesz usunąć to zadanie?</p>
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-clipboard"></i> Tytuł zadania: <i id="delete-task-title"></i>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Anuluj
                </button>
                <form action="" id="delete-form" method="GET">
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Usuń zadanie
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
