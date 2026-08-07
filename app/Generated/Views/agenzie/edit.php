<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'agenzia_id';
$formAction = site_url('agenzie/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('agenzie/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
