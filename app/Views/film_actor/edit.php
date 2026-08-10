<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'actor_id';
$formAction = site_url('film_actor/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('film_actor/_form', [
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
