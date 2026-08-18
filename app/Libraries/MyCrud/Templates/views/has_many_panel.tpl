    <?php
    $hasManyCollapseId = 'hasmany_' . preg_replace('/[^A-Za-z0-9_]/', '_', '{{RELATION_KEY}}');
    $hasManyCollapsible = {{COLLAPSIBLE}};
    $hasManyCollapsed = {{COLLAPSED}};
    ?>
    <div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <?php if ($hasManyCollapsible): ?>
                    <button
                        type="button"
                        class="btn btn-sm btn-link text-decoration-none p-0 d-print-none"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?= esc($hasManyCollapseId) ?>"
                        aria-expanded="<?= $hasManyCollapsed ? 'false' : 'true' ?>"
                        aria-controls="<?= esc($hasManyCollapseId) ?>"
                        title="Open/close child table"
                    ><i class="bi bi-chevron-down"></i></button>
                <?php endif; ?>
                <strong><i class="bi {{ICON}}"></i> {{TITLE}}</strong>
            </div>
            <div class="d-flex align-items-center gap-2 d-print-none">
                {{NEW_BUTTON}}
                {{VIEW_ALL_BUTTON}}
                {{COUNT_BADGE}}
            </div>
        </div>
        <div id="<?= esc($hasManyCollapseId) ?>" class="<?= $hasManyCollapsible ? 'collapse' . ($hasManyCollapsed ? '' : ' show') : '' ?>">
            <div class="card-body">
                <?php $relatedRows = $children['{{RELATION_KEY}}']['rows'] ?? []; ?>
                <?php if (empty($relatedRows)): ?>
                    <div class="alert alert-light border mb-0">No related record.</div>
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
                        <div class="small text-muted d-print-none">Visualizzati i primi {{LIMIT}} record.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
