<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'tipologia_id';
$formAction = site_url('tipologia_camera/update/' . ($row->{$primaryKey} ?? ''));
?>

<?= view('tipologia_camera/_form', [
    'formTitle'       => 'Modifica record',
    'formIcon'        => 'bi-pencil-square',
    'formAction'      => $formAction,
    'row'             => $row ?? null,
    'errors'          => $errors ?? [],
    'options'         => $options ?? [],
    'submissionToken' => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
