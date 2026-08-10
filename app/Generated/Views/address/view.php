<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #crud-print-area,
    #crud-print-area * {
        visibility: visible !important;
    }

    #crud-print-area {
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
    }

    #crud-print-area .d-print-none {
        display: none !important;
    }

    #crud-print-area .card {
        box-shadow: none !important;
        break-inside: auto;
    }

    /* Il dettaglio iniziale resta compatto; i pannelli hasMany possono invece
       iniziare nello spazio disponibile e proseguire sulla pagina successiva. */
    #crud-print-area > .card:first-child {
        break-inside: avoid;
    }
}
</style>

<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>

<div class="container py-4">
    <div class="d-print-none">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('address') . $navigationQuery ?>">address</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dettaglio</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h1 class="h3 mb-0">address</h1>
                <small class="text-muted">Dettaglio record</small>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="<?= site_url('address/create') . ($navigationQuery ?? '') ?>" class="btn btn-primary" title="Nuovo record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo
        </a>        <a href="<?= site_url('address') . ($navigationQuery ?? '') ?>" class="btn btn-outline-secondary" title="Torna alla lista">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> Lista
        </a>
        <a href="<?= site_url('address/edit/' . rawurlencode((string) ($row->{'address_id'} ?? ''))) . ($navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Modifica record">
            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i> Modifica
        </a>
        <form method="post" action="<?= site_url('address/delete/' . rawurlencode((string) ($row->{'address_id'} ?? ''))) . ($navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
            <?= csrf_field() ?>
            <?php foreach ((array) ($navigationContext ?? []) as $contextField => $contextValue): ?>
                <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-outline-danger" title="Cancella record">
                <i class="bi bi-trash me-1" aria-hidden="true"></i> Cancella
            </button>
        </form>        <button type="button" class="btn btn-outline-secondary" onclick="window.print()" title="Stampa dettaglio">
            <i class="bi bi-printer me-1" aria-hidden="true"></i> Stampa
        </button>            </div>
        </div>
    </div>

    <div id="crud-print-area">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped align-middle">
                        <tbody>
                        <tr>
                            <th class="w-25"><?= esc(lang('Address.address_id')) ?></th>
                            <td><?= esc($row->{'address_id'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.address')) ?></th>
                            <td><?= esc($row->{'address'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.address2')) ?></th>
                            <td><?= esc($row->{'address2'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.district')) ?></th>
                            <td><?= esc($row->{'district'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.city_id')) ?></th>
                            <td><a href="<?= site_url('city/view/' . rawurlencode((string) ($row->{'city_id'} ?? ''))) ?>" class="text-decoration-none"><?= esc($row->{'city_id__label'} ?? $row->{'city_id'} ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.postal_code')) ?></th>
                            <td><?= esc($row->{'postal_code'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.phone')) ?></th>
                            <td><?= esc($row->{'phone'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.location')) ?></th>
                            <td><?= esc($row->{'location'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Address.last_update')) ?></th>
                            <td><?= esc($row->{'last_update'} ?? '') ?></td>
                        </tr>                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <strong><i class="bi bi-diagram-3"></i> Customer</strong>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('customer/create') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-primary" title="Nuovo record collegato"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo</a>
                <span class="badge bg-secondary"><?= (int) ($children['customer__address_id']['count'] ?? 0) ?><?= !empty($children['customer__address_id']['hasMore']) ? '+' : '' ?></span>
            </div>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['customer__address_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Customer Id') ?></th>
                                <th><?= esc('Store Id') ?></th>
                                <th><?= esc('First Name') ?></th>
                                <th><?= esc('Last Name') ?></th>
                                <th><?= esc('Email') ?></th>
                                <th><?= esc('Address Id') ?></th>
                                <th><?= esc('Active') ?></th>
                                <th><?= esc('Create Date') ?></th>
                                <th><?= esc('Last Update') ?></th>
                            <th class="d-print-none">Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->{'customer_id'} ?? '') ?></td>
                                <td><?= esc($child->{'store_id'} ?? '') ?></td>
                                <td><?= esc($child->{'first_name'} ?? '') ?></td>
                                <td><?= esc($child->{'last_name'} ?? '') ?></td>
                                <td><?= esc($child->{'email'} ?? '') ?></td>
                                <td><?= esc($child->{'address_id'} ?? '') ?></td>
                                <td><?= esc($child->{'active'} ?? '') ?></td>
                                <td><?= esc($child->{'create_date'} ?? '') ?></td>
                                <td><?= esc($child->{'last_update'} ?? '') ?></td>
                                    <td class="d-print-none"><a href="<?= site_url('customer/view/' . rawurlencode((string) ($child->{'customer_id'} ?? ''))) . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-info" title="Visualizza record"><i class="bi bi-eye" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['customer__address_id']['hasMore'])): ?>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 d-print-none">
                        <div class="small text-muted">Visualizzati i primi 20 record.</div>
                        <a href="<?= site_url('customer') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-primary">
                            Vedi tutti <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <strong><i class="bi bi-diagram-3"></i> Staff</strong>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('staff/create') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-primary" title="Nuovo record collegato"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo</a>
                <span class="badge bg-secondary"><?= (int) ($children['staff__address_id']['count'] ?? 0) ?><?= !empty($children['staff__address_id']['hasMore']) ? '+' : '' ?></span>
            </div>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['staff__address_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Staff Id') ?></th>
                                <th><?= esc('First Name') ?></th>
                                <th><?= esc('Last Name') ?></th>
                                <th><?= esc('Address Id') ?></th>
                                <th><?= esc('Picture') ?></th>
                                <th><?= esc('Email') ?></th>
                                <th><?= esc('Store Id') ?></th>
                                <th><?= esc('Active') ?></th>
                                <th><?= esc('Username') ?></th>
                                <th><?= esc('Password') ?></th>
                                <th><?= esc('Last Update') ?></th>
                            <th class="d-print-none">Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->{'staff_id'} ?? '') ?></td>
                                <td><?= esc($child->{'first_name'} ?? '') ?></td>
                                <td><?= esc($child->{'last_name'} ?? '') ?></td>
                                <td><?= esc($child->{'address_id'} ?? '') ?></td>
                                <td><?= esc($child->{'picture'} ?? '') ?></td>
                                <td><?= esc($child->{'email'} ?? '') ?></td>
                                <td><?= esc($child->{'store_id'} ?? '') ?></td>
                                <td><?= esc($child->{'active'} ?? '') ?></td>
                                <td><?= esc($child->{'username'} ?? '') ?></td>
                                <td><?= esc($child->{'password'} ?? '') ?></td>
                                <td><?= esc($child->{'last_update'} ?? '') ?></td>
                                    <td class="d-print-none"><a href="<?= site_url('staff/view/' . rawurlencode((string) ($child->{'staff_id'} ?? ''))) . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-info" title="Visualizza record"><i class="bi bi-eye" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['staff__address_id']['hasMore'])): ?>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 d-print-none">
                        <div class="small text-muted">Visualizzati i primi 20 record.</div>
                        <a href="<?= site_url('staff') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-primary">
                            Vedi tutti <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <strong><i class="bi bi-diagram-3"></i> Store</strong>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('store/create') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-primary" title="Nuovo record collegato"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo</a>
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
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 d-print-none">
                        <div class="small text-muted">Visualizzati i primi 20 record.</div>
                        <a href="<?= site_url('store') . '?' . http_build_query(['address_id' => $row->{'address_id'} ?? '']) ?>" class="btn btn-sm btn-outline-primary">
                            Vedi tutti <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    </div>
</div>

<?= $this->endSection() ?>
