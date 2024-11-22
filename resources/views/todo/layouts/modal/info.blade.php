<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="infoModalLabel">
                    <i class="fas fa-info-circle"></i> Szczegóły zadania
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0" id="infoModal-title"></h5>
                                <small class="text-muted">
                                    <i class="fas fa-hashtag"></i> ID: <span id="infoModal-id"></span>
                                </small>
                            </div>
                            <div>
                                <span class="badge badge-pill" id="infoModal-status-badge"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Informacje o użytkownikach -->
                        <div class="user-info-section mb-3">
                            <div class="d-flex justify-content-between">
                                <div class="creator-info">
                                    <i class="fas fa-user-edit"></i>
                                    Utworzone przez: <br><span class="font-weight-bold" id="infoModal-who"></span>
                                </div>
                                <div class="assigned-info pr-5">
                                    <i class="fas fa-user-check"></i>
                                    Przypisane do: <br><span class="font-weight-bold" id="infoModal-assign"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Opis zadania -->
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2">
                                    <i class="fas fa-align-left"></i> Opis zadania:
                                </h6>
                                <p class="card-text" id="infoModal-description"></p>
                            </div>
                        </div>

                        <!-- Daty -->
                        <div class="dates-section">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-plus"></i> Data utworzenia:
                                        <br>
                                        <span id="infoModal-created"></span>
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-check"></i> Ostatnia aktualizacja:
                                        <br>
                                        <span id="infoModal-updated"></span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm float-right" data-dismiss="modal">
                            <i class="fas fa-times"></i> Zamknij
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#infoModal .modal-content {
    border-radius: 8px;
}

#infoModal .card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

#infoModal .user-info-section {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 6px;
}

#infoModal .user-info-section i {
    color: #6c757d;
    margin-right: 0.5rem;
}

#infoModal-status-badge {
    padding: 8px 12px;
    font-size: 0.9rem;
}

#infoModal-status-badge.status-1 {
    background-color: #dc3545;
    color: white;
}

#infoModal-status-badge.status-2 {
    background-color: #ffc107;
    color: black;
}

#infoModal-status-badge.status-3 {
    background-color: #28a745;
    color: white;
}

#infoModal .dates-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 6px;
}

#infoModal .card-text {
    white-space: pre-wrap;
}
</style>

<script>
$(document).ready(function() {
    $('#infoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        
        // Podstawowe informacje
        modal.find('#infoModal-id').text(button.data('id'));
        modal.find('#infoModal-title').text(button.data('title'));
        modal.find('#infoModal-description').text(button.data('description'));
        
        // Status
        var status = button.data('status');
        var statusName = button.data('status-name');
        var badge = modal.find('#infoModal-status-badge');
        badge.text(statusName);
        badge.removeClass('status-1 status-2 status-3').addClass('status-' + status);
        
        // Informacje o użytkownikach
        modal.find('#infoModal-who').text(button.data('who'));
        modal.find('#infoModal-assign').text(button.data('assign'));
        
        // Daty
        modal.find('#infoModal-created').text(button.data('created'));
        modal.find('#infoModal-updated').text(button.data('updated'));
    });
});
</script>
