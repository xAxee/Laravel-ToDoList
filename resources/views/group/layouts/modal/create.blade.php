<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModelLabel">Utwórz grupe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('group.post.store') }}" method="post" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="title" class="col-4 col-form-label">Nazwa</label>
                        <div class="col-8">
                            <input id="title" name="title" placeholder="Tytuł" type="text" class="form-control"
                                required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="description">Opis</label>
                        <div class="col-8">
                            <textarea id="description" name="description" style="resize: none;" cols="40" rows="5" class="form-control"
                                aria-describedby="descriptionHelpBlock" required="required"></textarea>
                            <span id="descriptionHelpBlock" class="form-text text-muted">Szczegółowy opis</span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button name="submit" type="submit" class="btn btn-success">Utwórz</button>
            </div>
            </form>
        </div>
    </div>
</div>
