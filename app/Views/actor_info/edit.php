<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'actor_id';
$formAction = site_url('actor_info/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('actor_info/_form', [
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
