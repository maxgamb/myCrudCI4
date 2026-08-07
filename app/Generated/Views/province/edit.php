<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'Prov';
$formAction = site_url('province/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('province/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
