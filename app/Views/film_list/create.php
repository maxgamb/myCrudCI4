<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('film_list/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('film_list/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'context'         => $context ?? [],
    'contextLabels'   => $contextLabels ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
