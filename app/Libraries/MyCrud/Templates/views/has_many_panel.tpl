    <div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <strong><i class="bi {{ICON}}"></i> {{TITLE}}</strong>
            <div class="d-flex align-items-center gap-2 d-print-none">
                {{NEW_BUTTON}}
                {{COUNT_BADGE}}
            </div>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['{{RELATION_KEY}}']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
{{HEADERS}}                            {{ACTION_HEADER}}
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
{{CELLS}}                                    {{ACTION_CELL}}
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['{{RELATION_KEY}}']['hasMore'])): ?>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 d-print-none">
                        <div class="small text-muted">Visualizzati i primi {{LIMIT}} record.</div>
                        <a href="{{VIEW_ALL_URL}}" class="btn btn-sm btn-outline-primary">
                            Vedi tutti <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
