<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'FID';
$formAction = site_url('nicer_but_slower_film_list/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('nicer_but_slower_film_list/_form', [
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
