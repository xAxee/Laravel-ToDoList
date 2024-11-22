<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="createModelLabel">
                    <i class="fas fa-edit"></i> Edytuj grupę
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('group.post.edit', 0) }}" id="editForm" method="post" class="needs-validation"
                    novalidate>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="title" class="col-4 col-form-label">
                            <i class="fas fa-heading"></i> Nazwa
                        </label>
                        <div class="col-8">
                            <input id="edit-title" name="title" placeholder="Tytuł" type="text"
                                class="form-control" required="required">
                            <div class="invalid-feedback">
                                Proszę podać nazwę grupy
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="description">
                            <i class="fas fa-align-left"></i> Opis
                        </label>
                        <div class="col-8">
                            <textarea id="edit-description" name="description" style="resize: none;" cols="40" rows="5"
                                class="form-control" aria-describedby="descriptionHelpBlock" required="required"></textarea>
                            <div class="invalid-feedback">
                                Proszę podać opis grupy
                            </div>
                            <small id="descriptionHelpBlock" class="form-text text-muted">
                                Szczegółowy opis grupy
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Zamknij
                        </button>
                        <button name="submit" type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Zapisz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
