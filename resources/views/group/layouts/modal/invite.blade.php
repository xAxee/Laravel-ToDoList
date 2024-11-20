<!-- Invite sModal -->
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inviteModalLabel">Udostępnij grupe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupAddon"><i class="fas fa-share-square"></i></div>
                    </div>
                    <input type="text" class="form-control" id="invite-link" onFocus="this.select()">
                </div>
                <small class="text-muted">Każda osoba mająca ten link będzie mogła dołączyć do twojej grupy</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-primary" onclick="copyInvite()"><i class="fas fa-clipboard"></i>
                    Kopiuj link</button>
            </div>
        </div>
    </div>
</div>
