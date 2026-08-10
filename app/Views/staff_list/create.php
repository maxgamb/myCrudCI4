<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('staff_list/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('staff_list/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'context'         => $context ?? [],
    'contextLabels'   => $contextLabels ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
