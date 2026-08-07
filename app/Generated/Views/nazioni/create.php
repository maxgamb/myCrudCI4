<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('nazioni/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('nazioni/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
