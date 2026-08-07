<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'pratica_id';
$formAction = site_url('pratiche/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('pratiche/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
