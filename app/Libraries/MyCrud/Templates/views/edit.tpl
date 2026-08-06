<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = '{{PRIMARY_KEY}}';
$formAction = site_url('{{ROUTE}}/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('{{VIEW_PATH}}/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
