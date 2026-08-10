<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'ID';
$formAction = site_url('staff_list/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('staff_list/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'context'         => [],
    'contextLabels'   => [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
