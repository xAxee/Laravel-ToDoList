<!-- Chart Modal -->
<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="chartModalLabel">
                    <i class="fas fa-chart-pie"></i> Statystyki zadań w grupie
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="chart-container mb-4">
                    <canvas id="myChart" style="width:100%;max-width:800px;margin:auto;"></canvas>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <i class="fas fa-list"></i> Do zrobienia
                                </h5>
                                <p class="card-text h4">{{ $first->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <i class="fas fa-tasks"></i> W trakcie
                                </h5>
                                <p class="card-text h4">{{ $second->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <i class="fas fa-check-circle"></i> Ukończone
                                </h5>
                                <p class="card-text h4">{{ $third->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Zamknij
                </button>
            </div>
        </div>
    </div>
</div>
