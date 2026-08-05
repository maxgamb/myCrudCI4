<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div class="container py-4">
<h1 class="h3"><?= esc($heading) ?></h1>
<div class="card"><div class="card-header"><button id="copyCode" class="btn btn-sm btn-primary">Copia</button></div>
<pre class="bg-dark text-light p-4 mb-0"><code id="generatedCode"><?= esc($code) ?></code></pre></div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>document.getElementById('copyCode')?.addEventListener('click', async function(){await navigator.clipboard.writeText(document.getElementById('generatedCode').textContent);this.textContent='Copiato';});</script>
<?= $this->endSection() ?>
