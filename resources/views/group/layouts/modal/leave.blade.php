<!-- Leave Modal -->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="leaveModalLabel">
                    <i class="fas fa-trash-alt"></i> Opuszczanie grupy
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> Uwaga! Ta operacja jest nieodwracalna.
                </div>
                <p>Czy na pewno chcesz opuścić tę grupę?</p>
            </div>
            <div class="modal-footer">
                <form action="" id="leave-form" method="POST">
                    {{ csrf_field() }}
                    <input hidden name="user_id" value="{{ Auth::user()->id }}">
                    <input hidden name="leave" value="true">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Anuluj
                    </button>
                    <button type="submit" class="btn btn-danger mr-2">Opuść</button>
                </form>
            </div>
        </div>
    </div>
</div>
