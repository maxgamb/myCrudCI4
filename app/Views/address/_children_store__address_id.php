<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <strong><i class="bi bi-diagram-3"></i> Store</strong>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('store/create') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '', '_parent_field' => 'address_id']) ?>" class="btn btn-sm btn-primary" title="Nuovo record collegato"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo</a>
                <a href="<?= site_url('store') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-primary" title="Vedi tutti i record collegati"><i class="bi bi-list-ul me-1" aria-hidden="true"></i> Vedi tutti</a>
                <span class="badge bg-secondary"><?= (int) ($children['store__address_id']['count'] ?? 0) ?><?= !empty($children['store__address_id']['hasMore']) ? '+' : '' ?></span>
            </div>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['store__address_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Store Id') ?></th>
                                <th><?= esc('Manager Staff Id') ?></th>
                                <th><?= esc('Address Id') ?></th>
                                <th><?= esc('Last Update') ?></th>
                            <th class="d-print-none">Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->{'store_id'} ?? '') ?></td>
                                <td><?= esc($child->{'manager_staff_id'} ?? '') ?></td>
                                <td><?= esc($child->{'address_id'} ?? '') ?></td>
                                <td><?= esc($child->{'last_update'} ?? '') ?></td>
                                    <td class="d-print-none"><a href="<?= site_url('store/view/' . rawurlencode((string) ($child->{'store_id'} ?? ''))) . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-info" title="Visualizza record"><i class="bi bi-eye" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['store__address_id']['hasMore'])): ?>
                    <div class="small text-muted d-print-none">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
