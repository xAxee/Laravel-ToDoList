<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit"></i> Edytuj zadanie
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editForm" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                    <div class="form-group row">
                        <label for="title" class="col-4 col-form-label">
                            <i class="fas fa-heading"></i> Tytuł
                        </label>
                        <div class="col-8">
                            <input id="edit-title" name="title" placeholder="Tytuł zadania" type="text"
                                class="form-control" required="required">
                            <div class="invalid-feedback">
                                Proszę podać tytuł zadania
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="description">
                            <i class="fas fa-align-left"></i> Opis
                        </label>
                        <div class="col-8">
                            <textarea id="edit-description" name="description" style="resize: none;" cols="40" rows="5"
                                class="form-control" aria-describedby="descriptionHelpBlock" required="required"
                                placeholder="Szczegółowy opis zadania"></textarea>
                            <div class="invalid-feedback">
                                Proszę podać opis zadania
                            </div>
                            <small id="descriptionHelpBlock" class="form-text text-muted">
                                Opisz szczegółowo zadanie do wykonania
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assign" class="col-4 col-form-label">
                            <i class="fas fa-user-tag"></i> Przypisz do
                        </label>
                        <div class="col-8">
                            <select id="assignEdit" name="assign" class="custom-select"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-4 col-form-label">
                            <i class="fas fa-tasks"></i> Status
                        </label>
                        <div class="col-8">
                            <select id="edit-status" name="status" class="custom-select" required="required">
                                @foreach(App\Models\Todo::getAvailableStatuses() as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', request('status')) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Proszę wybrać status
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Zamknij
                        </button>
                        <button name="submit" type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
