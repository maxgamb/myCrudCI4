<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\SubmissionGuard;
use App\Services\NicerButSlowerFilmListService;
use App\Validation\NicerButSlowerFilmListRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * Controller CRUD full per nicer_but_slower_film_list.
 *
 * Lato sito: coordina request, validazione, view e redirect. Le query restano
 * nel Model; Standard/Full demandano inoltre la logica applicativa al Service.
 * SQL VIEW: risorsa generata in sola lettura; eventuali scritture sono estensioni manuali.
 */
final class NicerButSlowerFilmListController extends BaseController
{
    /** Limiti export configurati al momento della generazione. */
    private const EXPORT_OPTIONS = [
        'csv' => [
            'chunkSize' => 2000,
            'maximumRows' => 150000,
            'unfilteredMaximumRows' => 25000,
        ],
        'word' => [
            'chunkSize' => 1000,
            'maximumRows' => 10000,
            'unfilteredMaximumRows' => 5000,
        ],
    ];

    /** Solo le FK reali della tabella possono viaggiare come contesto URL. */
    private const NAVIGATION_CONTEXT_FIELDS = array (
);

    /** FK autorizzate alla creazione atomica del record padre nello stesso form. */
    private const RELATED_CREATE_FIELDS = array (
);

    /**
     * Contesti parent ammessi per il Create avviato da una relazione hasMany.
     * La tabella di ritorno deriva esclusivamente dallo schema generato, mai dal POST.
     */
    private const PARENT_CONTEXT_FIELDS = array (
);

    private NicerButSlowerFilmListService $gateway;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new NicerButSlowerFilmListService();
        // Runtime comune del sito: una sola implementazione per export, input e token.
        $this->exporter = new CrudExporter();
        $this->inputProcessor = new CrudInputProcessor();
        $this->submissionGuard = new SubmissionGuard();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        $listRequest = CrudListRequest::fromRequest(
            $this->request,
            'FID',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
),
            array (
)
        );

        $navigationContext = $this->navigationContextFromQuery();
        $data = $this->gateway->listPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'nicer_but_slower_film_list',
            'primaryKey' => 'FID',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
            'navigationContext' => $navigationContext,
        ];

        if ($this->request->isAJAX()) {
            return view('nicer_but_slower_film_list/_table', $data);
        }

        $data['options'] = $this->gateway->relationOptions();

        return view('nicer_but_slower_film_list/index', $data);
    }

    /** Endpoint JSON usato dalle select AJAX delle relazioni grandi. */
    public function relationOptions(string $field)
    {
        $query = trim((string) $this->request->getGet('q'));
        if (strlen($query) < 2) {
            return $this->response->setJSON(['results' => []]);
        }

        return $this->response->setJSON([
            'results' => $this->gateway->searchRelationOptions($field, $query, 20),
        ]);
    }

    public function exportCsv()
    {
        return $this->export('csv');
    }

    public function exportWord()
    {
        return $this->export('word');
    }

    /**
     * Unifica CSV e Word: cambia solo il writer selezionato dalla libreria runtime.
     */
    private function export(string $format)
    {
        $options = self::EXPORT_OPTIONS[$format] ?? null;
        if (!is_array($options)) {
            throw new RuntimeException('Formato export non supportato.');
        }

        $listRequest = CrudListRequest::fromRequest($this->request, 'FID', array (
  0 => 25,
  1 => 50,
  2 => 100,
), array (
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'nicer_but_slower_film_list',
                languageGroup: 'NicerButSlowerFilmList',
                fields: $this->gateway->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->gateway->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->gateway->exportRows($filters, $limit, $after),
                primaryKey: 'FID',
                chunkSize: (int) $options['chunkSize'],
                maximumRows: (int) $options['maximumRows'],
                unfilteredMaximumRows: (int) $options['unfilteredMaximumRows']
            );
        } catch (RuntimeException $e) {
            if (str_starts_with($e->getMessage(), 'EXPORT_UNFILTERED_LIMIT:')) {
                return $this->exportLimitRedirect(strtoupper($format), true);
            }
            if (str_starts_with($e->getMessage(), 'EXPORT_LIMIT:')) {
                return $this->exportLimitRedirect(strtoupper($format), false);
            }
            throw $e;
        }
    }

    /** Recupera il record o converte l'assenza in un normale 404 del sito. */
    private function findRecordOrFail(int|string $id): object
    {
        try {
            $record = $this->gateway->find($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        if (!is_object($record)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return $record;
    }

    /**
     * Pulizia meccanica comune ai form. In Standard/Full date e password sono
     * preparate dal Service; in Basic vengono gestite qui dal runtime CRUD.
     */
    private function formData(bool $isUpdate): array
    {
        return $this->inputProcessor->process(
            $this->request->getPost(),
            $isUpdate,
            [],
            array (
),
            array (
),
            array (
),
            [],
            false
        );
    }

    /** @return array<string,array<string,mixed>> */
    private function relatedCreateDataFromPost(): array
    {
        $flags = $this->request->getPost('_related_new');
        $payload = $this->request->getPost('_related');
        $flags = is_array($flags) ? $flags : [];
        $payload = is_array($payload) ? $payload : [];
        $related = [];

        foreach (self::RELATED_CREATE_FIELDS as $field => $allowedFields) {
            if (empty($flags[$field]) || !isset($payload[$field]) || !is_array($payload[$field])) {
                continue;
            }
            $allowed = array_fill_keys((array) $allowedFields, true);
            $related[$field] = array_intersect_key($payload[$field], $allowed);
        }

        return $related;
    }

    /** @return array<string,string> */
    private function validateRelatedCreates(array $related): array
    {
        if ($related === []) {
            return [];
        }

        $definitions = NicerButSlowerFilmListRules::relatedCreateRules();
        $errors = [];
        foreach ($related as $field => $payload) {
            $relationRules = (array) ($definitions[$field] ?? []);
            if ($relationRules === []) {
                continue;
            }

            $validation = service('validation');
            $validation->reset();
            $validation->setRules($relationRules);
            if ($validation->run($payload)) {
                continue;
            }

            foreach ($validation->getErrors() as $relatedField => $message) {
                $errors[$field . '__related__' . $relatedField] = (string) $message;
            }
        }

        return $errors;
    }

    /** @return array<string,string> */
    private function navigationContextFromQuery(): array
    {
        return $this->sanitizeNavigationContext((array) $this->request->getGet());
    }

    /** @return array<string,string> */
    private function navigationContextFromPost(): array
    {
        $context = $this->request->getPost('_context');

        return $this->sanitizeNavigationContext(is_array($context) ? $context : []);
    }

    /** @return array<string,string> */
    private function sanitizeNavigationContext(array $source): array
    {
        $context = [];
        foreach (self::NAVIGATION_CONTEXT_FIELDS as $field) {
            $value = $source[$field] ?? null;
            if (!is_scalar($value) || trim((string) $value) === '') {
                continue;
            }
            $context[$field] = (string) $value;
        }

        return $context;
    }

    /** @return array{field:string,table:string,id:string,label:string,url:string}|array{} */
    private function parentContextFromQuery(array $navigationContext): array
    {
        return $this->parentContext((string) ($this->request->getGet('_parent_field') ?? ''), $navigationContext);
    }

    /** @return array{field:string,table:string,id:string,label:string,url:string}|array{} */
    private function parentContextFromPost(array $navigationContext): array
    {
        return $this->parentContext((string) ($this->request->getPost('_parent_field') ?? ''), $navigationContext);
    }

    /**
     * Risolve un ritorno contestuale sicuro verso il padre hasMany.
     * Il client sceglie solo la FK; tabella e route sono whitelist generate dallo schema.
     *
     * @return array{field:string,table:string,id:string,label:string,url:string}|array{}
     */
    private function parentContext(string $field, array $navigationContext): array
    {
        if ($field === '' || !isset(self::PARENT_CONTEXT_FIELDS[$field])) {
            return [];
        }
        $id = $navigationContext[$field] ?? null;
        if (!is_scalar($id) || trim((string) $id) === '') {
            return [];
        }
        $definition = self::PARENT_CONTEXT_FIELDS[$field];
        $table = (string) ($definition['table'] ?? '');
        if ($table === '') {
            return [];
        }
        $id = (string) $id;

        return [
            'field' => $field,
            'table' => $table,
            'id' => $id,
            'label' => (string) ($definition['label'] ?? $table),
            'url' => site_url($table . '/view/' . rawurlencode($id)),
        ];
    }

    private function contextUrl(string $path, array $context): string
    {
        $url = site_url($path);

        return $context === [] ? $url : $url . '?' . http_build_query($context);
    }

    private function exportLimitRedirect(string $format, bool $unfiltered)
    {
        $message = $unfiltered
            ? 'La tabella contiene troppi record per un export senza filtri. Applicare almeno un filtro prima di esportare in ' . $format . '.'
            : 'Il numero di record supera il limite configurato per ' . $format . '. Applicare filtri più restrittivi.';

        $query = (array) $this->request->getGet();
        $url = site_url('nicer_but_slower_film_list') . ($query === [] ? '' : '?' . http_build_query($query));

        return redirect()->to($url)->with('error', $message);
    }
}
