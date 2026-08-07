<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('sidae/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('sidae/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
