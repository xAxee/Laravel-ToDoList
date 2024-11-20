<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Informacje, id: <b id="infoModal-id"></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title" id="infoModal-title"></h5>
                        <h6 class="card-subtitle mb-2 text-muted" id="infoModal-who"></h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text" id="infoModal-description"></p>
                    </div>
                    <div class="card-footer">
                        <p>Status: <b id="infoModal-status"></b></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>
