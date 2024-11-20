<!-- Chart Modal -->
<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModalLabel">Wykres listy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
            </div>
            <div class="modal-footer">
                <p>Do zrobienia: {{ $first->count() }}</p>
                <p>W trakcie: {{ $second->count() }}</p>
                <p>Ukończone: {{ $third->count() }}</p>
            </div>
        </div>
    </div>
</div>
