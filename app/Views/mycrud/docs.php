<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-book me-1"></i> Documentazione</h1>
            <p class="text-muted mb-0">Guida rapida alle funzioni principali e al workflow di myCrudGpt.</p>
        </div>
        <span class="badge text-bg-dark fs-6">myCrudGpt <?= esc($version ?? '') ?></span>
    </div>

    <div class="row g-4">
        <aside class="col-12 col-lg-3 col-xl-2">
            <div class="list-group position-sticky" style="top: 1rem;">
                <a class="list-group-item list-group-item-action" href="#filosofia">Filosofia</a>
                <a class="list-group-item list-group-item-action" href="#quick">Quick</a>
                <a class="list-group-item list-group-item-action" href="#builder">Builder</a>
                <a class="list-group-item list-group-item-action" href="#architetture">Architetture</a>
                <a class="list-group-item list-group-item-action" href="#config">Config persistente</a>
                <a class="list-group-item list-group-item-action" href="#relazioni">Relazioni</a>
                <a class="list-group-item list-group-item-action" href="#menu">Menu Builder</a>
                <a class="list-group-item list-group-item-action" href="#ai-context">Contesto IA</a>
                <a class="list-group-item list-group-item-action" href="#strumenti">Diagnostica</a>
                <a class="list-group-item list-group-item-action" href="#comandi">Comandi Spark</a>
                <a class="list-group-item list-group-item-action" href="#workflow">Workflow consigliato</a>
            </div>
        </aside>

        <div class="col-12 col-lg-9 col-xl-10">
            <section id="filosofia" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Filosofia del progetto</h2>
                    <p>myCrudGpt trasforma lo schema del database e le scelte dello sviluppatore in codice CodeIgniter 4 controllabile e modificabile.</p>
                    <div class="bg-body-tertiary border rounded p-3 font-monospace small">
                        Database → Configurazione → myCrudGpt → app/Generated/ → controllo sviluppatore → app/
                    </div>
                    <div class="alert alert-info mt-3 mb-0">
                        <strong>Staging sicuro:</strong> il generatore scrive in <code>app/Generated/</code>. Il passaggio nell'applicazione operativa resta sotto controllo dello sviluppatore.
                    </div>
                </div>
            </section>

            <section id="quick" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-lightning-charge-fill me-1"></i> Quick</h2>
                    <p>La Quick serve a generare rapidamente uno o più CRUD usando solo informazioni certe ricavabili dal database.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <strong>Determina automaticamente</strong>
                                <ul class="mb-0 mt-2">
                                    <li>campi e tipi DB;</li>
                                    <li>primary key e indici;</li>
                                    <li>foreign key;</li>
                                    <li>nullability e auto increment;</li>
                                    <li>select o select AJAX per relazioni grandi;</li>
                                    <li>architettura scelta per la generazione.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <strong>Non decide</strong>
                                <ul class="mb-0 mt-2">
                                    <li>significato applicativo dei campi;</li>
                                    <li>descrizioni leggibili delle FK;</li>
                                    <li>link al padre o filtri rapidi;</li>
                                    <li>FK ricevute dalla URL;</li>
                                    <li>struttura funzionale del menu;</li>
                                    <li>business logic e permessi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="small text-muted mt-3 mb-0">Per una FK, la Quick usa inizialmente la chiave referenziata come valore descrittivo neutrale. Le personalizzazioni si fanno nel Builder.</p>
                </div>
            </section>

            <section id="builder" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-sliders me-1"></i> Builder</h2>
                    <p>Il Builder gestisce le decisioni che il database non può conoscere. È il punto in cui lo sviluppatore personalizza il CRUD.</p>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-2 small">
                        <?php foreach (['Label e input', 'Visibilità lista/form/dettaglio', 'Searchable e sortable', 'Validazione', 'Descrizione e template FK', 'Navigazione FK', 'Select / AJAX', 'API ed export', 'Relazioni hasMany', 'Opzioni UI'] as $item): ?>
                            <div class="col"><div class="border rounded p-2 h-100"><i class="bi bi-check2 me-1"></i><?= esc($item) ?></div></div>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>

            <section id="architetture" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Architetture</h2>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead><tr><th>Livello</th><th>Componenti</th><th>Flusso principale</th></tr></thead>
                            <tbody>
                                <tr><th>Basic</th><td>Controller, Model, Validation, Views, Routes</td><td><code>Controller → Model → DB</code></td></tr>
                                <tr><th>Standard</th><td>Basic + Entity + Service</td><td><code>Controller → Service → Model → DB</code></td></tr>
                                <tr><th>Full</th><td>Standard + API REST v1 + Resource + OpenAPI</td><td><code>API → Service → Model → Resource → JSON</code></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="config" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Configurazione persistente</h2>
                    <p>Le decisioni dello sviluppatore sono salvate in <code>app/MyCrudConfig/&lt;tabella&gt;.php</code>. Lo schema fisico viene invece riletto dal DB durante la generazione.</p>
                    <pre class="bg-dark text-light rounded p-3 mb-0"><code>app/MyCrudConfig/
├── agenda.php
├── clienti.php
└── camere.php</code></pre>
                </div>
            </section>

            <section id="relazioni" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Relazioni e Data Navigation</h2>
                    <p>Le FK vengono rilevate automaticamente. La loro presentazione e navigazione restano configurabili nel Builder.</p>
                    <ul class="mb-0">
                        <li><strong>displayField / displayTemplate:</strong> decide cosa mostrare all'utente;</li>
                        <li><strong>select AJAX:</strong> evita di caricare migliaia di option;</li>
                        <li><strong>filtro rapido:</strong> opzionale sui campi indicizzati/searchable;</li>
                        <li><strong>link al padre:</strong> opzionale per le FK;</li>
                        <li><strong>context URL:</strong> opzionale nel Create e sempre verificato server-side.</li>
                    </ul>
                </div>
            </section>

            <section id="menu" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Menu Builder</h2>
                    <p>Il menu è guidato dallo sviluppatore: le relazioni SQL sono informazioni utili, non regole automatiche di aggregazione.</p>
                    <div class="bg-body-tertiary border rounded p-3 font-monospace small">Voci non assegnate → Gruppi / Sottogruppi → Anteprima → Config/Menu.php → menu verticale o orizzontale</div>
                </div>
            </section>

            <section id="ai-context" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-robot me-1"></i> Contesto IA del progetto</h2>
                    <p>myCrudGpt può generare una mappa strutturata dell'applicazione per informare un agente IA su architettura, CRUD, campi, relazioni e convenzioni prima che modifichi il codice.</p>
                    <pre class="bg-dark text-light rounded p-3"><code>AI_PROJECT_CONTEXT.md
docs/ai/project.json
docs/ai/crud/&lt;tabella&gt;.md</code></pre>
                    <p class="mb-2">Il contesto non esporta record applicativi, credenziali, password o valori di <code>.env</code>.</p>
                    <a class="btn btn-sm btn-outline-primary" href="<?= site_url('mycrud/tools/ai-context') ?>">
                        <i class="bi bi-robot me-1"></i> Genera contesto IA
                    </a>
                </div>
            </section>

            <section id="strumenti" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Diagnostica e manutenzione</h2>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <tbody>
                                <tr><th><code>doctor</code></th><td>Controlla tabella, PK, indici e relazioni.</td></tr>
                                <tr><th><code>--explain</code></th><td>Mostra come MySQL esegue le query rappresentative.</td></tr>
                                <tr><th><code>benchmark</code></th><td>Misura COUNT, lista, pagina profonda e filtro indicizzato.</td></tr>
                                <tr><th><code>diff</code></th><td>Confronta una nuova generazione con app/ o app/Generated/ senza modificare file.</td></tr>
                                <tr><th><code>test-all</code></th><td>Esegue la suite di regressione Basic/Standard/Full.</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="comandi" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Comandi Spark principali</h2>
                    <?php foreach ([
                        'php spark mycrud:generate agenda',
                        'php spark mycrud:generate-all',
                        'php spark mycrud:diff agenda',
                        'php spark mycrud:doctor agenda',
                        'php spark mycrud:doctor agenda --explain',
                        'php spark mycrud:benchmark agenda',
                        'php spark mycrud:test-all agenda',
                        'php spark mycrud:ai-context',
                        'php spark mycrud:ai-context agenda',
                    ] as $command): ?>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <code class="bg-dark text-light rounded px-2 py-1 flex-grow-1"><?= esc($command) ?></code>
                            <button type="button" class="btn btn-sm btn-outline-secondary copy-command" data-command="<?= esc($command) ?>" title="Copia comando"><i class="bi bi-copy"></i></button>
                        </div>
                    <?php endforeach ?>
                </div>
            </section>

            <section id="workflow" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Workflow consigliato</h2>
                    <ol class="mb-0">
                        <li>Usa <strong>Quick</strong> per una prima generazione DB-driven oppure <strong>Builder</strong> per configurare il CRUD.</li>
                        <li>Controlla i file in <code>app/Generated/</code>.</li>
                        <li>Usa <code>mycrud:diff</code> quando devi rigenerare.</li>
                        <li>Sposta nell'applicazione operativa solo i file approvati.</li>
                        <li>Usa Doctor/EXPLAIN/Benchmark sui moduli più pesanti.</li>
                    </ol>
                </div>
            </section>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.querySelectorAll('.copy-command').forEach(button => {
    button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(button.dataset.command || '');
            const icon = button.querySelector('i');
            icon?.classList.replace('bi-copy', 'bi-check2');
            setTimeout(() => icon?.classList.replace('bi-check2', 'bi-copy'), 1200);
        } catch (error) {
            console.warn('Impossibile copiare il comando.', error);
        }
    });
});
</script>
<?= $this->endSection() ?>
