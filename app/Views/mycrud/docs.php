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
                <a class="list-group-item list-group-item-action" href="#builder-fields">Campi Builder</a>
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
                    <p>La Quick rilegge sempre lo schema dal database. Se esiste una configurazione persistente, mantiene le decisioni già salvate dallo sviluppatore e le applica allo schema corrente.</p>
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
                                    <li>filtri rapidi, context URL e altre opzioni applicative;</li>
                                    <li>FK ricevute dalla URL;</li>
                                    <li>struttura funzionale del menu;</li>
                                    <li>business logic e permessi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="small text-muted mt-3 mb-0">Per una FK nuova, la Quick usa la chiave referenziata come valore descrittivo neutrale e abilita il link al record padre. Se il Builder ha già configurato esplicitamente la navigazione, quella scelta viene preservata.</p>
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

            <section id="builder-fields" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-ui-checks-grid me-1"></i> Guida ai campi del Builder</h2>
                    <p class="text-body-secondary">Ogni campo del database mantiene il proprio nome tecnico, ma il Builder decide come viene presentato e usato dal CRUD. Quando il campo è una Foreign Key compaiono anche le opzioni di relazione.</p>

                    <div class="table-responsive mb-4">
                        <table class="table table-sm align-middle">
                            <thead><tr><th>Voce</th><th>Significato</th><th>Indicazione pratica</th></tr></thead>
                            <tbody>
                                <tr><th>Tipo input</th><td>Controllo HTML usato nel form: text, number, date, select, textarea, checkbox, ecc.</td><td>Per una FK normalmente usare <code>select</code> o select AJAX.</td></tr>
                                <tr><th>Caricamento relazione</th><td>Decide se le opzioni FK vengono caricate tutte oppure cercate via AJAX.</td><td><strong>Select completa</strong> per tabelle piccole; <strong>AJAX</strong> per tabelle grandi.</td></tr>
                                <tr><th>Valore descrittivo</th><td>Campo della tabella padre mostrato al posto della chiave numerica.</td><td>Esempio: <code>language_id=1</code> può essere mostrato come <em>English</em> usando <code>name</code>.</td></tr>
                                <tr><th>Template descrittivo</th><td>Composizione opzionale di più campi del padre, ad esempio <code>{cognome} {nome}</code>.</td><td>Se compilato prevale sul singolo valore descrittivo.</td></tr>
                                <tr><th>Label</th><td>Testo leggibile mostrato all'utente.</td><td>Per <code>language_id</code> è preferibile “Lingua” o “Language”, non “Language Id”.</td></tr>
                                <tr><th>Larghezza Bootstrap</th><td>Dimensione del campo nella griglia Bootstrap.</td><td><code>col-md-6</code> occupa metà riga; <code>col-md-12</code> tutta la riga.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="h6">Navigazione relazione</h3>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm align-middle">
                            <tbody>
                                <tr><th>Filtro rapido nella tabella</th><td>Rende disponibile una navigazione/lista filtrata usando la FK, quando l'indice e la policy di ricerca lo consentono.</td></tr>
                                <tr><th>Link al record padre</th><td>Il valore descrittivo della FK diventa un link alla View del record padre.</td></tr>
                                <tr><th>Accetta la FK dalla URL nel Create</th><td>Permette un flusso padre → “Nuovo figlio”. La FK ricevuta nella query string viene sempre validata sulla tabella padre prima della precompilazione.</td></tr>
                                <tr><th>Link “Nuovo padre” nel form</th><td>Mostra un collegamento al Create del CRUD padre. È navigazione verso un'altra pagina, non creazione inline. Se Relational Create è attivo viene disabilitato automaticamente, perché uscire dal form corrente farebbe perdere i dati non salvati.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="h6">Creazione record collegato</h3>
                    <div class="alert alert-info">
                        <strong>“Seleziona oppure crea nuovo”</strong> consente di scegliere un record padre esistente oppure crearne uno nello stesso form. La creazione inline si apre in un <strong>Bootstrap Offcanvas</strong> sovrapposto alla vista, senza spostare o modificare il pannello originario, e carica un <strong>partial dedicato ai soli campi del padre</strong> (<code>_related_create_&lt;fk&gt;.php</code>), non la pagina <code>create.php</code> completa del CRUD padre. Il nuovo padre e il record corrente vengono salvati nella stessa transazione; la PK generata dal padre viene imposta server-side come FK del record corrente. Quando questa modalità è attiva, il link “Nuovo padre” viene spento automaticamente: le due modalità sono alternative e l’Offcanvas preserva il form corrente. La select FK originale resta visivamente invariata; nelle FK standard select e azioni correlate vengono raccolte in un <strong>Bootstrap input-group</strong>: “Apri padre” usa l’icona <code>bi-box-arrow-up-right</code>, mentre Relational Create usa <code>bi-plus-circle</code> + testo breve <strong>Nuovo</strong>. Il server usa il nuovo padre solo quando lo stato <code>_related_new</code> è attivo.
                    </div>
                    <p>La FK del record corrente non viene accettata dal payload del nuovo padre: è il codice generato a imporla. I campi PK auto increment, FK tecnica e campi <code>databaseManaged</code> restano esclusi dalla scrittura inline. Per anagrafiche stabili (ad esempio una tabella lingue) questa opzione può rimanere disattivata; è più utile per entità create durante il normale flusso operativo, come un nuovo cliente durante una prenotazione.</p>

                    <h3 class="h6">Attributi booleani</h3>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm align-middle">
                            <tbody>
                                <tr><th>required</th><td>Campo obbligatorio. La validazione server-side resta l'autorità; il browser fornisce anche il controllo client-side.</td></tr>
                                <tr><th>readonly</th><td>Valore visibile ma non modificabile quando il tipo di controllo lo supporta. Non equivale a <code>disabled</code>.</td></tr>
                                <tr><th>disabled</th><td>Disabilita il controllo; un input HTML disabled non viene inviato nel POST.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="h6">Comportamento CRUD e API</h3>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm align-middle">
                            <tbody>
                                <tr><th>Ricercabile</th><td>Il campo può comparire nel filtro dinamico Campo/Criterio/Valore, nel rispetto delle policy sugli indici.</td></tr>
                                <tr><th>Ordinabile</th><td>Il campo può essere usato nell'ordinamento controllato della lista.</td></tr>
                                <tr><th>Visibile elenco</th><td>Mostra il campo nell'Index. Per una FK viene privilegiato il valore descrittivo.</td></tr>
                                <tr><th>Visibile form</th><td>Mostra il campo in Create/Edit, salvo campi tecnicamente gestiti dal database.</td></tr>
                                <tr><th>Visibile dettaglio</th><td>Mostra il campo nella View del record.</td></tr>
                                <tr><th>Sensibile</th><td>Segnala un dato da trattare con maggiore cautela; non va usato per una FK ordinaria solo perché è un ID.</td></tr>
                                <tr><th>Esportabile CSV/Word</th><td>Include il campo negli export, sempre attraverso la whitelist generata.</td></tr>
                                <tr><th>Visibile API</th><td>Espone il campo nell'API generata quando l'architettura lo prevede.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="h6">Attributi HTML</h3>
                    <p class="mb-0"><code>max</code>, <code>step</code>, <code>pattern</code> e <code>placeholder</code> configurano il controllo HTML. Sono utili soprattutto per input numerici o testuali; in una FK resa come select normalmente <code>max</code>, <code>step</code> e <code>pattern</code> non servono.</p>
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

            <section id="db-special" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-database-check me-1"></i> Casi DB speciali</h2>
                    <p class="text-body-secondary">myCrudGpt distingue i casi in cui una generazione CRUD completa non sarebbe sicura.</p>
                    <ul class="mb-0">
                        <li><strong>VIEW MySQL:</strong> generate in sola lettura (lista, filtri, pager, export e API GET). Nessun create/edit/delete.</li>
                        <li><strong>Primary key composta:</strong> rilevata integralmente. Il Create web resta disponibile perché non richiede di identificare un record preesistente; View/Edit/Delete restano protetti finché le route non gestiscono l'identità composta. L'export usa tutte le colonne PK come cursore.</li>
                        <li><strong>Tipi spatial:</strong> possono essere mostrati in lista/dettaglio/relazioni in forma testuale tramite <code>ST_AsText()</code>, ma restano esclusi da form, filtri, ordinamento, export e API.</li>
                        <li><strong>hasMany:</strong> la preview mantiene tutti i campi della tabella figlia, senza limite numerico, e usa lo scroll orizzontale quando necessario.</li>
                    </ul>
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
                    <p class="text-body-secondary">Nella view, le relazioni hasMany mostrano una preview limitata (20 record di default). <strong>Vedi tutti</strong> apre il CRUD figlio già filtrato per la FK e, quando il figlio è creabile, <strong>Nuovo</strong> apre il relativo Create ricordando la stessa FK. Le toolbar usano azioni coerenti tra Index, View, Create ed Edit e mantengono nella navigazione le FK presenti nella query string.</p>
                    <p>Le FK vengono rilevate automaticamente. La loro presentazione e navigazione restano configurabili nel Builder.</p>
                    <ul class="mb-0">
                        <li><strong>displayField / displayTemplate:</strong> decide cosa mostrare all'utente;</li>
                        <li><strong>select AJAX:</strong> evita di caricare migliaia di option;</li>
                        <li><strong>filtro rapido:</strong> opzionale sui campi indicizzati/searchable; usa URL brevi come <code>?language_id=1</code>, poi normalizzati nello stesso motore filtri;</li>
                        <li><strong>link al padre:</strong> attivo di default nella Quick perché la destinazione della FK è certa; resta modificabile nel Builder;</li>
                        <li><strong>context URL:</strong> le FK reali possono precompilare il Create tramite query string e vengono sempre verificate server-side;</li>
                        <li><strong>seleziona oppure crea nuovo:</strong> il Builder può abilitare, per una FK compatibile, la creazione del record padre nello stesso submit; padre e record corrente vengono salvati nella stessa transazione.</li>
                    </ul>
                </div>
            </section>

            <section id="colonne" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Colonne generate</h2>
                    <p class="mb-2">Le tabelle generate non applicano un limite numerico alle colonne: tutti i campi visualizzabili dello schema vengono inclusi. Restano esclusi solo valori sensibili o binari non adatti alla stampa raw; i tipi spatial vengono mostrati in forma testuale. Il programmatore può poi ridurre la visualizzazione dal Builder o intervenendo sul codice generato.</p>
                    <p class="mb-0"><code>MEDIUMTEXT</code> e <code>LONGTEXT</code> vengono abbreviati solo nelle viste tabellari; dettaglio, form ed export mantengono il contenuto completo.</p>
                </div>
            </section>

            <section id="export" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5"><i class="bi bi-download me-1"></i> Export</h2>
                    <p class="mb-2">CSV e Word esportano i risultati che soddisfano i filtri correnti, non soltanto la pagina visibile. I record vengono letti a chunk per evitare <code>findAll()</code> e carichi di memoria proporzionali alla dimensione della tabella.</p>
                    <ul class="mb-0">
                        <li>CSV: chunk configurabili, limite totale e limite più prudente quando non è applicato alcun filtro.</li>
                        <li>Word: limite inferiore rispetto al CSV, perché documenti HTML molto grandi diventano poco gestibili.</li>
                        <li>Se il limite viene superato, il download viene bloccato e viene richiesto di applicare filtri più restrittivi.</li>
                    </ul>
                </div>
            </section>

            <section id="menu" class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">Menu Builder</h2>
                    <p>Il menu è guidato dallo sviluppatore: le relazioni SQL sono informazioni utili, non regole automatiche di aggregazione.</p>
                    <div class="bg-body-tertiary border rounded p-3 font-monospace small">Voci non assegnate → Gruppi / Sottogruppi → Salva configurazione → Genera → menu verticale o orizzontale</div>
                    <p class="small text-muted mt-2 mb-0">La configurazione del Menu Builder viene salvata separatamente in <code>app/MyCrudConfig/Project/Menu.php</code>; la generazione continua a scrivere soltanto in <code>app/Generated/</code>.</p>
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
                                <tr><th><code>doctor</code></th><td>Controlla DB + configurazione persistente: schema, PK, indici e relazioni. Non analizza app/ o app/Generated/.</td></tr>
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
