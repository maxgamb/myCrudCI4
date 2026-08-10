<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('sales_by_film_category/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('sales_by_film_category/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'context'         => $context ?? [],
    'contextLabels'   => $contextLabels ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
