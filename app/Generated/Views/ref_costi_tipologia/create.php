<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?= view('ref_costi_tipologia/_form', [
    'formTitle'       => 'Nuovo record',
    'formIcon'        => 'bi-plus-circle',
    'formAction'      => site_url('ref_costi_tipologia/store'),
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
