<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>


<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-sliders"></i>
                Configura tabella: <?= esc($table) ?>
            </h1>

            <small class="text-muted">
                Trascina i campi per modificarne l’ordine e personalizza il form.
            </small>
        </div>

        <div class="btn-group">
            <button
                type="button"
                class="btn btn-outline-secondary"
                id="expandAll" >
                <i class="bi bi-arrows-expand"></i>
                Espandi
            </button>

            <button
                type="button"
                class="btn btn-outline-secondary"
                id="collapseAll" >
                <i class="bi bi-arrows-collapse"></i>
                Comprimi
            </button>

            <button
                type="button"
                class="btn btn-primary"
                id="showPreview"  >
                <i class="bi bi-eye"></i>
                Anteprima
            </button>
        </div>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= esc(session('message')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= esc(session('error')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <form method="post" id="builderForm">
        <?= csrf_field() ?>

        <input
            type="hidden"
            name="table"
            value="<?= esc($table) ?>"
        >

        <!-- ARCHITETTURA -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <strong>
                    <i class="bi bi-diagram-3"></i>
                    Architettura
                </strong>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <?php
                    $architectures = [
                        'basic' => [
                            'icon'        => 'bi-lightning-charge',
                            'title'       => 'Basic',
                            'description' => 'Controller, Model, Validation e Views',
                            'class'       => 'secondary',
                        ],
                        'standard' => [
                            'icon'        => 'bi-building',
                            'title'       => 'Standard',
                            'description' => 'Basic, Service ed Entity',
                            'class'       => 'primary',
                        ],
                        'full' => [
                            'icon'        => 'bi-rocket-takeoff',
                            'title'       => 'Full',
                            'description' => 'Standard, API REST e DataTables',
                            'class'       => 'success',
                        ],
                    ];
                    ?>

                    <?php foreach ($architectures as $value => $item): ?>
                        <div class="col-md-4">

                            <input
                                type="radio"
                                class="btn-check architecture-radio"
                                name="architecture"
                                id="architecture_<?= esc($value) ?>"
                                value="<?= esc($value) ?>"
                                <?= ($config['architecture'] ?? 'standard') === $value
                                    ? 'checked'
                                    : '' ?>
                            >

                            <label
                                class="btn btn-outline-<?= esc($item['class']) ?> w-100 h-100 p-3"
                                for="architecture_<?= esc($value) ?>"
                            >
                                <i class="bi <?= esc($item['icon']) ?> fs-2"></i>

                                <div class="fw-bold mt-2">
                                    <?= esc($item['title']) ?>
                                </div>

                                <small>
                                    <?= esc($item['description']) ?>
                                </small>
                            </label>
                        </div>
                    <?php endforeach; ?>

                </div>

                <hr>

                <?php
                $featureLabels = [
                    'entity'        => 'Entity',
                    'service'       => 'Service',
                    'api'           => 'API REST',
                    'datatable'     => 'DataTables',
                    'relations'     => 'Relazioni FK',
                    'timestamps'    => 'Timestamp',
                    'softDeletes'   => 'Soft delete',
                    'exportButtons' => 'Pulsanti export',
                ];
                ?>

                <div class="row g-3">

                    <?php foreach ($featureLabels as $feature => $label): ?>
                        <?php
                        $softDeleteDisabled =
                            $feature === 'softDeletes'
                            && empty($config['softDelete']['available']);
                        ?>

                        <div class="col-md-3 col-sm-6">
                            <div class="form-check form-switch">

                                <input
                                    class="form-check-input feature-check"
                                    type="checkbox"
                                    name="features[<?= esc($feature) ?>]"
                                    value="1"
                                    id="feature_<?= esc($feature) ?>"
                                    <?= !empty($config['features'][$feature])
                                        ? 'checked'
                                        : '' ?>
                                    <?= $softDeleteDisabled
                                        ? 'disabled'
                                        : '' ?>
                                >

                                <label
                                    class="form-check-label"
                                    for="feature_<?= esc($feature) ?>"
                                >
                                    <?= esc($label) ?>
                                </label>

                                <?php if ($softDeleteDisabled): ?>
                                    <div class="form-text">
                                        Richiede il campo
                                        <code>
                                            <?= esc(
                                                $config['softDelete']['field']
                                                ?? 'deleted_at'
                                            ) ?>
                                        </code>
                                        nullable.
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="alert alert-info mt-3 mb-0">
                    <i class="bi bi-info-circle"></i>

                    Le view utilizzano sempre oggetti:

                    <code>$row-&gt;campo</code>.

                    Basic restituisce oggetti standard; Standard e Full
                    possono usare Entity.
                </div>
            </div>
        </div>

        <!-- CAMPI -->
        <div id="sortableFields">

            <?php foreach ($config['order'] as $fieldName): ?>
                <?php
                if (!isset($config['fields'][$fieldName])) {
                    continue;
                }

                $field = $config['fields'][$fieldName];
                $foreignKey = $field['foreignKey'] ?? null;

                $allowedTypes = [
                    'text',
                    'number',
                    'email',
                    'password',
                    'date',
                    'datetime-local',
                    'time',
                    'month',
                    'week',
                    'textarea',
                    'select',
                    'checkbox',
                    'radio',
                    'url',
                    'tel',
                    'file',
                    'image',
                    'hidden',
                    'range',
                    'color',
                    'search',
                ];

                $typeIcons = [
                    'text'           => '📝',
                    'number'         => '🔢',
                    'email'          => '✉️',
                    'password'       => '🔐',
                    'date'           => '📅',
                    'datetime-local' => '⏰',
                    'time'           => '🕒',
                    'month'          => '📆',
                    'week'           => '📆',
                    'textarea'       => '✍️',
                    'select'         => '📂',
                    'checkbox'       => '☑️',
                    'radio'          => '🔘',
                    'url'            => '🌐',
                    'tel'            => '📞',
                    'file'           => '📁',
                    'image'          => '🖼️',
                    'hidden'         => '👁️‍🗨️',
                    'range'          => '🎚️',
                    'color'          => '🎨',
                    'search'         => '🔍',
                ];
                ?>

                <div
                    class="card shadow-sm mb-3 field-block"
                    data-field="<?= esc($fieldName) ?>"
                >

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="d-flex flex-wrap align-items-center gap-2">

                            <span
                                class="drag-handle fs-4"
                                title="Trascina per ordinare"
                                style="cursor: grab;"
                            >
                                ☰
                            </span>

                            <strong>
                                <?= esc($fieldName) ?>
                            </strong>

                            <?php if (!empty($field['primary'])): ?>
                                <span class="badge bg-secondary">
                                    PK
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($field['unique'])): ?>
                                <span class="badge bg-info text-dark">
                                    UNIQUE
                                </span>
                            <?php endif; ?>

                            <?php if ($foreignKey): ?>
                                <span class="badge bg-warning text-dark">
                                    FK →
                                    <?= esc($foreignKey['parentTable'] ?? '') ?>
                                </span>
                            <?php endif; ?>

                            <span class="badge bg-light text-dark border">
                                <?= esc($field['columnType'] ?? $field['type'] ?? '') ?>
                            </span>

                        </div>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary toggle-field"
                            title="Comprimi o espandi"
                        >
                            <i class="bi bi-chevron-up"></i>
                        </button>
                    </div>

                    <div class="card-body field-body">

                        <div class="row g-3">

                            <!-- TIPO INPUT -->
                            <div class="col-lg-4">
                                <label class="form-label">
                                    Tipo input
                                </label>

                                <select
                                    name="inputType[<?= esc($fieldName) ?>]"
                                    class="form-select input-type"
                                >
                                    <?php foreach ($allowedTypes as $type): ?>
                                        <option
                                            value="<?= esc($type) ?>"
                                            <?= ($field['inputType'] ?? 'text') === $type
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            <?= esc(
                                                ($typeIcons[$type] ?? '')
                                                . ' '
                                                . $type
                                            ) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- LABEL -->
                            <div class="col-lg-4">
                                <label class="form-label">
                                    Label
                                </label>

                
                                
                                
                            <input
                            type="text"
                            name="label[<?= esc($fieldName) ?>]"
                            value="<?= esc($field['label'] ?? '') ?>"
                            placeholder="<?= esc(
                            $field['defaultLabel']
                            ?? $fieldName
                            ) ?>"
                            class="form-control field-label"
                            >
                                
<div class="form-text">
    Lascia vuoto per utilizzare:

    <code>
        <?= esc(
            $field['languageKey']
            ?? 'Fields.' . $fieldName
        ) ?>
    </code>
</div>
                                
                                
                                <div class="form-text">
                                    Il valore iniziale proviene da
                                    <code>Language/it/Fields.php</code>.
                                </div>
                            </div>

                            <!-- WIDTH -->
                            <div class="col-lg-4">
                                <label class="form-label">
                                    Larghezza Bootstrap
                                </label>

                                <select
                                    name="width[<?= esc($fieldName) ?>]"
                                    class="form-select width-select"
                                >
                                    <?php for ($width = 12; $width >= 1; $width--): ?>
                                        <option
                                            value="<?= $width ?>"
                                            <?= (int) ($field['width'] ?? 6) === $width
                                                ? 'selected'
                                                : '' ?>
                                        >
                                            col-md-<?= $width ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

              <!-- ATTRIBUTI BOOLEANI -->
<div class="col-lg-4">
    <label class="form-label d-block">
        Attributi booleani
    </label>

    <?php
    $booleanAttributes = [
        'required' => '⭐',
        'readonly' => '🔒',
        'disabled' => '🚫',
    ];

    $booleanValues = $field['attributes']['boolean'] ?? [];

    $isNotNullable = ($field['nullable'] ?? true) === false;
    $isAutoIncrement = !empty($field['autoIncrement']);
    $isDisabled = in_array('disabled', $booleanValues, true);
    ?>

    <?php foreach ($booleanAttributes as $attribute => $icon): ?>
        <?php
        $isChecked = in_array(
            $attribute,
            $booleanValues,
            true
        );

        /*
         * Se il campo DB è NOT NULL,
         * required viene selezionato automaticamente,
         * tranne per i campi autoincrementali.
         */
        if (
            $attribute === 'required'
            && $isNotNullable
            && !$isAutoIncrement
        ) {
            $isChecked = true;
        }

        /*
         * Un campo disabled non può essere required.
         */
        if (
            $attribute === 'required'
            && $isDisabled
        ) {
            $isChecked = false;
        }

        $inputId = $fieldName . '_' . $attribute;
        ?>

        <div class="form-check form-check-inline">
            <input
                type="checkbox"
                class="form-check-input attribute-boolean"
                name="attrBool[<?= esc($fieldName) ?>][]"
                value="<?= esc($attribute) ?>"
                id="<?= esc($inputId) ?>"
                <?= $isChecked ? 'checked' : '' ?>
            >

            <label
                class="form-check-label"
                for="<?= esc($inputId) ?>"
            >
                <?= $icon ?>
                <?= esc($attribute) ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>

                            <!-- ATTRIBUTI CON VALORE -->
                            <div class="col-lg-8">
                                <label class="form-label">
                                    Attributi con valore
                                </label>

                                <?php
                                $valueAttributes = [
                                    'maxlength',
                                    'minlength',
                                    'min',
                                    'max',
                                    'step',
                                    'pattern',
                                    'placeholder',
                                ];
                                ?>

                                <div class="row g-2">

                                    <?php foreach ($valueAttributes as $attribute): ?>
                                        <div class="col-md-4">

                                            <div class="input-group input-group-sm">

                                                <span class="input-group-text">
                                                    <?= esc($attribute) ?>
                                                </span>

                                                <input
                                                    type="text"
                                                    name="attrVal[<?= esc($fieldName) ?>][<?= esc($attribute) ?>]"
                                                    value="<?= esc(
                                                        $field['attributes']['values'][$attribute]
                                                        ?? ''
                                                    ) ?>"
                                                    class="form-control"
                                                >

                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>

                            <!-- INFO DB -->
                            <div class="col-12">
                                <div class="border rounded bg-light p-3">

                                    <div class="row g-2 small">

                                        <div class="col-md-3">
                                            <strong>Tipo DB:</strong>
                                            <?= esc($field['columnType'] ?? '') ?>
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Nullable:</strong>
                                            <?= !empty($field['nullable'])
                                                ? 'Sì'
                                                : 'No' ?>
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Default:</strong>
                                            <?= esc(
                                                $field['default']
                                                ?? 'NULL'
                                            ) ?>
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Auto increment:</strong>
                                            <?= !empty($field['autoIncrement'])
                                                ? 'Sì'
                                                : 'No' ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <!-- ORDINE CAMPI -->
        <div id="orderContainer"></div>

        <!-- COMANDI -->
        <div class="sticky-bottom bg-light border-top py-3 mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                <a
                    href="<?= site_url('mycrud') ?>"
                    class="btn btn-secondary"
                >
                    <i class="bi bi-arrow-left"></i>
                    Tabelle
                </a>

                <div class="d-flex flex-wrap gap-2">

                    <div class="form-check form-switch align-self-center me-2">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="force"
                            value="1"
                            id="force"
                        >

                        <label
                            class="form-check-label"
                            for="force"
                        >
                            Sovrascrivi file esistenti
                        </label>
                    </div>

                    <button
                        type="submit"
                        formaction="<?= site_url(
                            'mycrud/builder/save'
                        ) ?>"
                        class="btn btn-outline-success"
                    >
                        <i class="bi bi-floppy"></i>
                        Salva configurazione
                    </button>

                    <button
                        type="submit"
                        formaction="<?= site_url(
                            'mycrud/builder/generate'
                        ) ?>"
                        class="btn btn-warning"
                    >
                        <i class="bi bi-gear"></i>
                        Genera CRUD
                    </button>

                </div>
            </div>
        </div>

    </form>
</div>

<!-- MODALE ANTEPRIMA -->
<div
    class="modal fade"
    id="previewModal"
    tabindex="-1"
    aria-labelledby="previewModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="previewModalLabel"
                >
                    <i class="bi bi-eye"></i>
                    Anteprima form completo
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Chiudi"
                ></button>
            </div>

            <div class="modal-body">

                <div class="alert alert-info">
                    L’anteprima riflette ordine, label, tipo input e
                    larghezza Bootstrap configurati.
                </div>

                <div id="previewContent"></div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sortableFields = document.getElementById(
        'sortableFields'
    );

    const orderContainer = document.getElementById(
        'orderContainer'
    );

    const previewButton = document.getElementById(
        'showPreview'
    );

    const previewContent = document.getElementById(
        'previewContent'
    );

    const previewModal = document.getElementById(
        'previewModal'
    );

    const emojiForType = {
        text: '📝',
        number: '🔢',
        email: '✉️',
        password: '🔐',
        date: '📅',
        'datetime-local': '⏰',
        time: '🕒',
        month: '📆',
        week: '📆',
        color: '🎨',
        checkbox: '☑️',
        radio: '🔘',
        select: '📂',
        file: '📁',
        image: '🖼️',
        hidden: '👁️‍🗨️',
        range: '🎚️',
        search: '🔍',
        tel: '📞',
        url: '🌐',
        textarea: '✍️'
    };

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = String(value);

        return element.innerHTML;
    }

    function cssEscape(value) {
        if (
            window.CSS
            && typeof window.CSS.escape === 'function'
        ) {
            return window.CSS.escape(value);
        }

        return String(value).replace(
            /([ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g,
            '\\$1'
        );
    }

    function generateFieldHtml(
        type,
        fieldName,
        attributes
    ) {
        const safeName = escapeHtml(fieldName);
        const required = attributes.required
            ? 'required'
            : '';

        const readonly = attributes.readonly
            ? 'readonly'
            : '';

        const disabled = attributes.disabled
            ? 'disabled'
            : '';

        const placeholder = attributes.placeholder
            ? `placeholder="${escapeHtml(
                attributes.placeholder
            )}"`
            : '';

        const maxlength = attributes.maxlength
            ? `maxlength="${escapeHtml(
                attributes.maxlength
            )}"`
            : '';

        const minlength = attributes.minlength
            ? `minlength="${escapeHtml(
                attributes.minlength
            )}"`
            : '';

        const min = attributes.min
            ? `min="${escapeHtml(attributes.min)}"`
            : '';

        const max = attributes.max
            ? `max="${escapeHtml(attributes.max)}"`
            : '';

        const step = attributes.step
            ? `step="${escapeHtml(attributes.step)}"`
            : '';

        const pattern = attributes.pattern
            ? `pattern="${escapeHtml(
                attributes.pattern
            )}"`
            : '';

        const commonAttributes = [
            required,
            readonly,
            disabled,
            placeholder,
            maxlength,
            minlength,
            min,
            max,
            step,
            pattern
        ].filter(Boolean).join(' ');

        switch (type) {
            case 'hidden':
                return `
                    <input
                        type="hidden"
                        name="${safeName}"
                        value=""
                    >

                    <div class="form-text">
                        Campo nascosto
                    </div>
                `;

            case 'number':
                return `
                    <input
                        type="number"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'email':
                return `
                    <input
                        type="email"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'password':
                return `
                    <input
                        type="password"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'date':
                return `
                    <input
                        type="date"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'datetime-local':
                return `
                    <input
                        type="datetime-local"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'time':
                return `
                    <input
                        type="time"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'month':
                return `
                    <input
                        type="month"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'week':
                return `
                    <input
                        type="week"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'color':
                return `
                    <input
                        type="color"
                        name="${safeName}"
                        class="form-control form-control-color"
                        ${commonAttributes}
                    >
                `;

            case 'textarea':
                return `
                    <textarea
                        name="${safeName}"
                        class="form-control"
                        rows="3"
                        ${commonAttributes}
                    ></textarea>
                `;

            case 'select':
                return `
                    <select
                        name="${safeName}"
                        class="form-select"
                        ${required}
                        ${disabled}
                    >
                        <option value="">
                            Seleziona...
                        </option>

                        <option value="1">
                            Opzione 1
                        </option>

                        <option value="2">
                            Opzione 2
                        </option>
                    </select>
                `;

            case 'radio':
                return `
                    <div class="form-check">
                        <input
                            type="radio"
                            name="${safeName}"
                            class="form-check-input"
                            value="1"
                            id="${safeName}_radio_1"
                            ${required}
                            ${disabled}
                        >

                        <label
                            class="form-check-label"
                            for="${safeName}_radio_1"
                        >
                            Opzione 1
                        </label>
                    </div>

                    <div class="form-check">
                        <input
                            type="radio"
                            name="${safeName}"
                            class="form-check-input"
                            value="2"
                            id="${safeName}_radio_2"
                            ${disabled}
                        >

                        <label
                            class="form-check-label"
                            for="${safeName}_radio_2"
                        >
                            Opzione 2
                        </label>
                    </div>
                `;

            case 'checkbox':
                return `
                    <div class="form-check">
                        <input
                            type="checkbox"
                            name="${safeName}"
                            class="form-check-input"
                            value="1"
                            id="${safeName}_checkbox"
                            ${required}
                            ${disabled}
                        >

                        <label
                            class="form-check-label"
                            for="${safeName}_checkbox"
                        >
                            Seleziona
                        </label>
                    </div>
                `;

            case 'range':
                return `
                    <input
                        type="range"
                        name="${safeName}"
                        class="form-range"
                        ${commonAttributes}
                    >
                `;

            case 'search':
                return `
                    <input
                        type="search"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'tel':
                return `
                    <input
                        type="tel"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'url':
                return `
                    <input
                        type="url"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;

            case 'file':
                return `
                    <input
                        type="file"
                        name="${safeName}"
                        class="form-control"
                        ${required}
                        ${disabled}
                    >
                `;

            case 'image':
                return `
                    <input
                        type="file"
                        name="${safeName}"
                        class="form-control"
                        accept="image/*"
                        ${required}
                        ${disabled}
                    >
                `;

            default:
                return `
                    <input
                        type="text"
                        name="${safeName}"
                        class="form-control"
                        ${commonAttributes}
                    >
                `;
        }
    }

    function updateOrder() {
        if (!orderContainer) {
            return;
        }

        orderContainer.innerHTML = '';

        document
            .querySelectorAll('.field-block')
            .forEach(function (block) {
                const hidden = document.createElement(
                    'input'
                );

                hidden.type = 'hidden';
                hidden.name = 'order[]';
                hidden.value = block.dataset.field;

                orderContainer.appendChild(hidden);
            });
    }

    function readFieldAttributes(block, fieldName) {
        const attributes = {
            required: false,
            readonly: false,
            disabled: false,
            maxlength: '',
            minlength: '',
            min: '',
            max: '',
            step: '',
            pattern: '',
            placeholder: ''
        };

        block
            .querySelectorAll(
                `input[name="attrBool[${cssEscape(
                    fieldName
                )}][]"]`
            )
            .forEach(function (input) {
                if (input.checked) {
                    attributes[input.value] = true;
                }
            });

        [
            'maxlength',
            'minlength',
            'min',
            'max',
            'step',
            'pattern',
            'placeholder'
        ].forEach(function (attribute) {
            const input = block.querySelector(
                `input[name="attrVal[${cssEscape(
                    fieldName
                )}][${attribute}]"]`
            );

            attributes[attribute] = input?.value?.trim()
                || '';
        });

        return attributes;
    }

    function buildPreview() {
        let formHtml = `
            <form class="row g-3">
        `;

        document
            .querySelectorAll('.field-block')
            .forEach(function (block) {
                const fieldName = block.dataset.field;

                const labelInput = block.querySelector(
                    `input[name="label[${cssEscape(
                        fieldName
                    )}]"]`
                );

                const typeSelect = block.querySelector(
                    '.input-type'
                );

                const widthSelect = block.querySelector(
                    '.width-select'
                );

            
        
//             const label = labelInput?.value?.trim()
//                    || fieldName;
            
            const label = labelInput?.value?.trim()
    || labelInput?.placeholder?.trim()
    || fieldName;
            

                const type = typeSelect?.value
                    || 'text';

                let width = Number.parseInt(
                    widthSelect?.value || '6',
                    10
                );

                if (
                    Number.isNaN(width)
                    || width < 1
                    || width > 12
                ) {
                    width = 6;
                }

                const icon = emojiForType[type]
                    || '';

                const attributes = readFieldAttributes(
                    block,
                    fieldName
                );

                const fieldHtml = generateFieldHtml(
                    type,
                    fieldName,
                    attributes
                );

                const requiredBadge = attributes.required
                    ? `
                        <span class="badge bg-danger ms-1">
                            obbligatorio
                        </span>
                    `
                    : '';

                const readonlyBadge = attributes.readonly
                    ? `
                        <span class="badge bg-secondary ms-1">
                            readonly
                        </span>
                    `
                    : '';

                const disabledBadge = attributes.disabled
                    ? `
                        <span class="badge bg-dark ms-1">
                            disabled
                        </span>
                    `
                    : '';

                formHtml += `
                    <div class="col-md-${width} mb-3">
                        <label class="form-label">
                            ${icon}
                            ${escapeHtml(label)}
                            ${requiredBadge}
                            ${readonlyBadge}
                            ${disabledBadge}
                        </label>

                        ${fieldHtml}
                    </div>
                `;
            });

        formHtml += `
            </form>
        `;

        return formHtml;
    }

    if (sortableFields) {
        new Sortable(sortableFields, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-warning',
            onSort: updateOrder
        });
    }

    updateOrder();

    previewButton?.addEventListener(
        'click',
        function () {
            if (!previewContent || !previewModal) {
                return;
            }

            previewContent.innerHTML = buildPreview();

            bootstrap.Modal
                .getOrCreateInstance(previewModal)
                .show();
        }
    );

    document
        .querySelectorAll('.toggle-field')
        .forEach(function (button) {
            button.addEventListener(
                'click',
                function () {
                    const block = button.closest(
                        '.field-block'
                    );

                    const body = block?.querySelector(
                        '.field-body'
                    );

                    const icon = button.querySelector(
                        'i'
                    );

                    if (!body) {
                        return;
                    }

                    body.classList.toggle('d-none');

                    if (icon) {
                        icon.className = body.classList
                            .contains('d-none')
                            ? 'bi bi-chevron-down'
                            : 'bi bi-chevron-up';
                    }
                }
            );
        });

    document
        .getElementById('expandAll')
        ?.addEventListener(
            'click',
            function () {
                document
                    .querySelectorAll('.field-body')
                    .forEach(function (body) {
                        body.classList.remove('d-none');
                    });

                document
                    .querySelectorAll('.toggle-field i')
                    .forEach(function (icon) {
                        icon.className =
                            'bi bi-chevron-up';
                    });
            }
        );

    document
        .getElementById('collapseAll')
        ?.addEventListener(
            'click',
            function () {
                document
                    .querySelectorAll('.field-body')
                    .forEach(function (body) {
                        body.classList.add('d-none');
                    });

                document
                    .querySelectorAll('.toggle-field i')
                    .forEach(function (icon) {
                        icon.className =
                            'bi bi-chevron-down';
                    });
            }
        );

    document
        .querySelectorAll('.field-block')
        .forEach(function (block) {
            const disabled = block.querySelector(
                'input[value="disabled"]'
            );

            const required = block.querySelector(
                'input[value="required"]'
            );

            if (!disabled || !required) {
                return;
            }

            function synchronizeRequired() {
                if (disabled.checked) {
                    required.checked = false;
                    required.disabled = true;
                } else {
                    required.disabled = false;
                }
            }

            disabled.addEventListener(
                'change',
                synchronizeRequired
            );

            synchronizeRequired();
        });

    document
        .querySelectorAll('.architecture-radio')
        .forEach(function (radio) {
            radio.addEventListener(
                'change',
                function () {
                    const architecture = this.value;

                    const entity = document.getElementById(
                        'feature_entity'
                    );

                    const service = document.getElementById(
                        'feature_service'
                    );

                    const api = document.getElementById(
                        'feature_api'
                    );

                    if (architecture === 'basic') {
                        if (entity) {
                            entity.checked = false;
                            entity.disabled = true;
                        }

                        if (service) {
                            service.checked = false;
                            service.disabled = true;
                        }

                        if (api) {
                            api.checked = false;
                        }
                    }

                    if (architecture === 'standard') {
                        if (entity) {
                            entity.checked = true;
                            entity.disabled = false;
                        }

                        if (service) {
                            service.checked = true;
                            service.disabled = false;
                        }

                        if (api) {
                            api.checked = false;
                        }
                    }

                    if (architecture === 'full') {
                        if (entity) {
                            entity.checked = true;
                            entity.disabled = false;
                        }

                        if (service) {
                            service.checked = true;
                            service.disabled = false;
                        }

                        if (api) {
                            api.checked = true;
                        }
                    }
                }
            );
        });
});
</script>

<?= $this->endSection() ?>

