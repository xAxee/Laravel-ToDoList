<!-- Invite Modal -->
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="inviteModalLabel">
                    <i class="fas fa-share-alt"></i> Udostępnij grupę
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-link"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="invite-link" onFocus="this.select()" readonly>
                </div>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> Każda osoba mająca ten link będzie mogła dołączyć do twojej grupy
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Zamknij
                </button>
                <button type="button" class="btn btn-primary" onclick="copyInvite()">
                    <i class="fas fa-clipboard"></i> Kopiuj link
                </button>
            </div>
        </div>
    </div>
</div>
