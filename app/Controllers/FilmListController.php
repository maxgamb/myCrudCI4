<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudListRequest;
use App\Models\FilmListModel;
use RuntimeException;

/**
 * Read-only controller for SQL VIEW `film_list`.
 *
 * Responsibilities:
 * - AJAX/paginated list with authorized filters and sorting;
 * - export CSV e Word;
 * - no Create/Edit/Delete operations and no form helpers.
 *
 * Contains no SQL queries.
 */
final class FilmListController extends BaseController
{
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

    private FilmListModel $model;
    private CrudExporter $exporter;

    public function __construct()
    {
        helper(['url']);
        $this->model = new FilmListModel();
        $this->exporter = new CrudExporter();
    }

    /** Displays the complete read-only list or the AJAX fragment. */
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

        $data = $this->model->getListPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'film_list',
            'primaryKey' => 'FID',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
            'navigationContext' => [],
            'cascadeTrail' => [],
            'options' => [],
        ];

        if ($this->request->isAJAX()) {
            return view('film_list/_table', $data);
        }

        return view('film_list/index', $data);
    }

    /** Streams the current filtered result set as CSV. */
    public function exportCsv()
    {
        return $this->export('csv');
    }

    /** Streams the current filtered result set as a Word-compatible document. */
    public function exportWord()
    {
        return $this->export('word');
    }

    /** Unifies CSV and Word through the shared runtime library. */
    private function export(string $format)
    {
        $options = self::EXPORT_OPTIONS[$format] ?? null;
        if (!is_array($options)) {
            throw new RuntimeException('Unsupported export format.');
        }

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

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'film_list',
                languageGroup: 'FilmList',
                fields: $this->model->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->model->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->model->getExportRows($filters, $limit, $after),
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

    private function exportLimitRedirect(string $format, bool $unfiltered)
    {
        $message = $unfiltered
            ? 'The view contains too many records for an unfiltered export. Apply at least one filter before exporting to ' . $format . '.'
            : 'The number of records exceeds the configured limit for ' . $format . '. Apply more restrictive filters.';

        $query = (array) $this->request->getGet();
        $url = site_url('film_list') . ($query === [] ? '' : '?' . http_build_query($query));

        return redirect()->to($url)->with('error', $message);
    }
}
