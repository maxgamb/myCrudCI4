<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'category';
$formAction = site_url('sales_by_film_category/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('sales_by_film_category/_form', [
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
