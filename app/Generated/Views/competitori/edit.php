<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'competitore_id';
$formAction = site_url('competitori/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('competitori/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
