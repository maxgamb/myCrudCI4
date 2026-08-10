<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('actor_info/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('actor_info/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'context'         => $context ?? [],
    'contextLabels'   => $contextLabels ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
