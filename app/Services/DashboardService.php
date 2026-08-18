<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Dashboard\DashboardData;
use App\DTO\Dashboard\DashboardWidget;
use App\DTO\Dashboard\Kpi;
use App\DTO\Dashboard\RecentRecord;
use App\Libraries\Dashboard\DashboardQuery;
use App\Models\FilmModel;

/**
 * Read-only Dashboard composition service.
 *
 * Aggregate/statistical reads are delegated to DashboardQuery. Recent-record
 * reads reuse concrete generated CRUD Models wired at generation-time. Entities
 * returned by those Models are normalized through RecentRecord DTOs before the
 * View boundary. Selected belongsTo values are projected through explicit generated
 * Model option methods wired at generation-time; no runtime relation resolver is used.
 */
final class DashboardService
{
    private const CONFIG = array (
  'name' => 'main',
  'title' => 'Application Dashboard',
  'route' => 'dashboard',
  'globalDateFilter' => 
  array (
    'enabled' => false,
    'label' => 'Period',
  ),
  'globalFilters' => 
  array (
  ),
  'widgets' => 
  array (
    0 => 
    array (
      'id' => 'widget_msyfe6h8_wbnso',
      'type' => 'kpi_count',
      'title' => 'Film Count',
      'table' => 'film',
      'modelClass' => 'App\\Models\\FilmModel',
      'modelShort' => 'FilmModel',
      'primaryKey' => 'film_id',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'film_id' => 'Film Id',
        'title' => 'Title',
        'description' => 'Description',
        'release_year' => 'Release Year',
        'language_id' => 'Language',
        'original_language_id' => 'Original Language',
        'rental_duration' => 'Rental Duration',
        'rental_rate' => 'Rental Rate',
        'length' => 'Length',
        'replacement_cost' => 'Replacement Cost',
        'rating' => 'Rating',
        'special_features' => 'Special Features',
        'last_update' => 'Last Update',
        'uploads' => 'Uploads',
      ),
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'recentRelations' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
      'recommendedWidth' => 3,
    ),
    1 => 
    array (
      'id' => 'widget_msyfeaqr_xr89o',
      'type' => 'kpi_aggregate',
      'title' => 'Total Rental Duration',
      'table' => 'film',
      'modelClass' => 'App\\Models\\FilmModel',
      'modelShort' => 'FilmModel',
      'primaryKey' => 'film_id',
      'operation' => 'SUM',
      'valueField' => 'rental_duration',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'film_id' => 'Film Id',
        'title' => 'Title',
        'description' => 'Description',
        'release_year' => 'Release Year',
        'language_id' => 'Language',
        'original_language_id' => 'Original Language',
        'rental_duration' => 'Rental Duration',
        'rental_rate' => 'Rental Rate',
        'length' => 'Length',
        'replacement_cost' => 'Replacement Cost',
        'rating' => 'Rating',
        'special_features' => 'Special Features',
        'last_update' => 'Last Update',
        'uploads' => 'Uploads',
      ),
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'recentRelations' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
      'recommendedWidth' => 3,
    ),
    2 => 
    array (
      'id' => 'widget_msyfeee6_t2yy9',
      'type' => 'quick_link',
      'title' => 'Film',
      'table' => 'film',
      'modelClass' => 'App\\Models\\FilmModel',
      'modelShort' => 'FilmModel',
      'primaryKey' => 'film_id',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'film_id' => 'Film Id',
        'title' => 'Title',
        'description' => 'Description',
        'release_year' => 'Release Year',
        'language_id' => 'Language',
        'original_language_id' => 'Original Language',
        'rental_duration' => 'Rental Duration',
        'rental_rate' => 'Rental Rate',
        'length' => 'Length',
        'replacement_cost' => 'Replacement Cost',
        'rating' => 'Rating',
        'special_features' => 'Special Features',
        'last_update' => 'Last Update',
        'uploads' => 'Uploads',
      ),
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'recentRelations' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
      'recommendedWidth' => 3,
    ),
    3 => 
    array (
      'id' => 'widget_msyfzl9f_bff96',
      'type' => 'kpi_count',
      'title' => 'Country Count',
      'table' => 'country',
      'modelClass' => 'App\\Models\\CountryModel',
      'modelShort' => 'CountryModel',
      'primaryKey' => 'country_id',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'country_id' => 'Country Id',
        'country' => 'Country',
        'last_update' => 'Last Update',
      ),
      'recentFields' => 
      array (
        0 => 'country_id',
        1 => 'country',
        2 => 'last_update',
      ),
      'recentRelations' => 
      array (
      ),
      'limit' => 5,
      'width' => 3,
      'recommendedWidth' => 3,
    ),
    4 => 
    array (
      'id' => 'widget_msyfecza_fah6g',
      'type' => 'grouped_chart',
      'title' => 'Film Count by Rating',
      'table' => 'film',
      'modelClass' => 'App\\Models\\FilmModel',
      'modelShort' => 'FilmModel',
      'primaryKey' => 'film_id',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => 'rating',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'film_id' => 'Film Id',
        'title' => 'Title',
        'description' => 'Description',
        'release_year' => 'Release Year',
        'language_id' => 'Language',
        'original_language_id' => 'Original Language',
        'rental_duration' => 'Rental Duration',
        'rental_rate' => 'Rental Rate',
        'length' => 'Length',
        'replacement_cost' => 'Replacement Cost',
        'rating' => 'Rating',
        'special_features' => 'Special Features',
        'last_update' => 'Last Update',
        'uploads' => 'Uploads',
      ),
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'recentRelations' => 
      array (
      ),
      'limit' => 5,
      'width' => 4,
      'recommendedWidth' => 4,
    ),
    5 => 
    array (
      'id' => 'widget_msyfedu3_7x619',
      'type' => 'recent',
      'title' => 'Recent Film records',
      'table' => 'film',
      'modelClass' => 'App\\Models\\FilmModel',
      'modelShort' => 'FilmModel',
      'primaryKey' => 'film_id',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => '',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'film_id' => 'Film Id',
        'title' => 'Title',
        'description' => 'Description',
        'release_year' => 'Release Year',
        'language_id' => 'Language',
        'original_language_id' => 'Original Language',
        'rental_duration' => 'Rental Duration',
        'rental_rate' => 'Rental Rate',
        'length' => 'Length',
        'replacement_cost' => 'Replacement Cost',
        'rating' => 'Rating',
        'special_features' => 'Special Features',
        'last_update' => 'Last Update',
        'uploads' => 'Uploads',
      ),
      'recentFields' => 
      array (
        0 => 'film_id',
        1 => 'title',
        2 => 'description',
        3 => 'release_year',
        4 => 'language_id',
        5 => 'original_language_id',
      ),
      'recentRelations' => 
      array (
        'language_id' => 
        array (
          'alias' => 'language_id__label',
          'label' => 'Language',
          'findMethod' => 'findLanguageIdOption',
        ),
        'original_language_id' => 
        array (
          'alias' => 'original_language_id__label',
          'label' => 'Original Language',
          'findMethod' => 'findOriginalLanguageIdOption',
        ),
      ),
      'limit' => 5,
      'width' => 4,
      'recommendedWidth' => 12,
    ),
    6 => 
    array (
      'id' => 'widget_msyfsgxx_kjwr0',
      'type' => 'grouped_chart',
      'title' => 'Actor Count by First Name',
      'table' => 'actor',
      'modelClass' => 'App\\Models\\ActorModel',
      'modelShort' => 'ActorModel',
      'primaryKey' => 'actor_id',
      'operation' => 'COUNT',
      'valueField' => '',
      'groupField' => 'first_name',
      'chartType' => 'bar',
      'dateGroup' => 'raw',
      'decimals' => 0,
      'prefix' => '',
      'suffix' => '',
      'filter' => 
      array (
        'field' => '',
        'label' => '',
        'operator' => 'eq',
        'value' => '',
      ),
      'globalDateField' => '',
      'globalDateLabel' => '',
      'globalFilters' => 
      array (
      ),
      'fieldLabels' => 
      array (
        'actor_id' => 'Actor Id',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'last_update' => 'Last Update',
      ),
      'recentFields' => 
      array (
        0 => 'actor_id',
        1 => 'first_name',
        2 => 'last_name',
        3 => 'last_update',
      ),
      'recentRelations' => 
      array (
      ),
      'limit' => 5,
      'width' => 4,
      'recommendedWidth' => 4,
    ),
  ),
);

    public function __construct(private ?DashboardQuery $query = null)
    {
        $this->query ??= new DashboardQuery();
    }

    /** @param array{from?:string,to?:string} $runtimeDateRange */
    public function build(
        array $runtimeDateRange = [],
        array $runtimeGlobalValues = []
    ): DashboardData {
        $widgets = [];
        $from = trim((string) ($runtimeDateRange['from'] ?? ''));
        $to = trim((string) ($runtimeDateRange['to'] ?? ''));

        foreach ((array) self::CONFIG['widgets'] as $widget) {
            $type = (string) ($widget['type'] ?? '');
            $filter = (array) ($widget['filter'] ?? []);
            $title = (string) ($widget['title'] ?? '');
            $width = (int) ($widget['width'] ?? 4);

            $dateRange = [];
            $dateField = trim((string) ($widget['globalDateField'] ?? ''));
            if (!empty(self::CONFIG['globalDateFilter']['enabled']) && $dateField !== '') {
                $dateRange = [
                    'field' => $dateField,
                    'label' => (string) ($widget['globalDateLabel'] ?? $dateField),
                    'from' => $from,
                    'to' => $to,
                ];
            }

            $globalFilters = $this->runtimeGlobalFilters(
                (array) ($widget['globalFilters'] ?? []),
                $runtimeGlobalValues
            );

            if ($type === 'kpi_count') {
                $value = $this->query->count((string) ($widget['table'] ?? ''), $filter, $dateRange, $globalFilters);
                $widgets[] = new DashboardWidget('kpi', $title, $width, [
                    'data' => new Kpi(
                        $title,
                        $value,
                        $this->formatNumber(
                            $value,
                            (int) ($widget['decimals'] ?? 0),
                            (string) ($widget['prefix'] ?? ''),
                            (string) ($widget['suffix'] ?? '')
                        )
                    ),
                    'filter' => $filter,
                    'dateRange' => $dateRange,
                    'globalFilters' => $globalFilters,
                ]);
                continue;
            }

            if ($type === 'kpi_aggregate') {
                $operation = (string) ($widget['operation'] ?? 'COUNT');
                $value = $this->query->aggregate(
                    (string) ($widget['table'] ?? ''),
                    (string) $widget['valueField'],
                    $operation,
                    $filter,
                    $dateRange,
                    $globalFilters
                );

                $widgets[] = new DashboardWidget('kpi', $title, $width, [
                    'data' => new Kpi(
                        $title,
                        $value,
                        $this->formatNumber(
                            $value,
                            (int) ($widget['decimals'] ?? 2),
                            (string) ($widget['prefix'] ?? ''),
                            (string) ($widget['suffix'] ?? '')
                        )
                    ),
                    'operation' => $operation,
                    'field' => (string) $widget['valueField'],
                    'fieldLabel' => (string) (($widget['fieldLabels'][$widget['valueField']] ?? $widget['valueField'])),
                    'filter' => $filter,
                    'dateRange' => $dateRange,
                    'globalFilters' => $globalFilters,
                ]);
                continue;
            }

            if ($type === 'grouped_chart') {
                $points = $this->query->grouped(
                    (string) ($widget['table'] ?? ''),
                    (string) $widget['groupField'],
                    (string) ($widget['operation'] ?? 'COUNT'),
                    (string) $widget['valueField'],
                    (string) (($widget['dateGroup'] ?? 'raw') ?? 'raw'),
                    (int) $widget['limit'],
                    $filter,
                    $dateRange,
                    $globalFilters
                );

                $widgets[] = new DashboardWidget('chart', $title, $width, [
                    'chartType' => (string) $widget['chartType'],
                    'operation' => (string) ($widget['operation'] ?? 'COUNT'),
                    'dateGroup' => (string) (($widget['dateGroup'] ?? 'raw') ?? 'raw'),
                    'groupField' => (string) $widget['groupField'],
                    'groupLabel' => (string) (($widget['fieldLabels'][$widget['groupField']] ?? $widget['groupField'])),
                    'valueField' => (string) $widget['valueField'],
                    'valueLabel' => (string) (($widget['fieldLabels'][$widget['valueField']] ?? $widget['valueField'])),
                    'points' => $points,
                    'filter' => $filter,
                    'dateRange' => $dateRange,
                    'globalFilters' => $globalFilters,
                ]);
                continue;
            }

            if ($type === 'recent') {
                $records = match ((string) ($widget['id'] ?? '')) {
            'widget_msyfedu3_7x619' => $this->recentWidgetWidgetmsyfedu37x619($filter, $dateRange, $globalFilters, (int) $widget['limit'], (array) ($widget['recentFields'] ?? []), (string) ($widget['primaryKey'] ?? 'id')),
            default => [],
                };

                $widgets[] = new DashboardWidget('recent', $title, $width, [
                    'table' => (string) ($widget['table'] ?? ''),
                    'records' => $records,
                    'fields' => (array) ($widget['recentFields'] ?? []),
                    'labels' => (array) ($widget['fieldLabels'] ?? []),
                    'filter' => $filter,
                    'dateRange' => $dateRange,
                    'globalFilters' => $globalFilters,
                ]);
                continue;
            }

            if ($type === 'quick_link') {
                $widgets[] = new DashboardWidget('quick_link', $title, $width, [
                    'table' => (string) ($widget['table'] ?? ''),
                ]);
            }
        }

        return new DashboardData(
            (string) self::CONFIG['title'],
            (array) (self::CONFIG['globalDateFilter'] ?? []),
            ['from' => $from, 'to' => $to],
            (array) (self::CONFIG['globalFilters'] ?? []),
            $runtimeGlobalValues,
            $widgets
        );
    }

    private function runtimeGlobalFilters(array $mappings, array $values): array
    {
        $filters = [];

        foreach ($mappings as $mapping) {
            if (!is_array($mapping)) {
                continue;
            }

            $id = (string) ($mapping['id'] ?? '');
            $field = trim((string) ($mapping['field'] ?? ''));
            $value = $values[$id] ?? null;

            if ($id === '' || $field === '' || $value === null || $value === '') {
                continue;
            }

            $inputType = (string) ($mapping['inputType'] ?? 'text');
            if ($inputType === 'number' && !is_numeric($value)) {
                continue;
            }

            $filters[] = [
                'id' => $id,
                'label' => (string) ($mapping['label'] ?? $id),
                'field' => $field,
                'fieldLabel' => (string) ($mapping['fieldLabel'] ?? $field),
                'operator' => (string) ($mapping['operator'] ?? 'eq'),
                'value' => $value,
            ];
        }

        return $filters;
    }

    private function applyModelFilters(object $model, array $filters): void
    {
        foreach ($filters as $filter) {
            if (is_array($filter)) {
                $this->applyModelFilter($model, $filter);
            }
        }
    }

    private function formatNumber(int|float $value, int $decimals, string $prefix, string $suffix): string
    {
        $number = number_format($value, max(0, min(4, $decimals)), '.', ',');

        return trim($prefix . $number . $suffix);
    }

    private function applyModelFilter(object $model, array $filter): void
    {
        $field = trim((string) ($filter['field'] ?? ''));
        $operator = (string) ($filter['operator'] ?? 'eq');
        $value = $filter['value'] ?? null;

        if ($field === '' || $value === null || $value === '') {
            return;
        }

        match ($operator) {
            'eq' => $model->where($field, $value),
            'neq' => $model->where($field . ' !=', $value),
            'gt' => $model->where($field . ' >', $value),
            'gte' => $model->where($field . ' >=', $value),
            'lt' => $model->where($field . ' <', $value),
            'lte' => $model->where($field . ' <=', $value),
            'contains' => $model->like($field, (string) $value, 'both'),
            'starts_with' => $model->like($field, (string) $value, 'after'),
            default => null,
        };
    }

    private function applyModelDateRange(object $model, array $dateRange): void
    {
        $field = trim((string) ($dateRange['field'] ?? ''));
        $from = trim((string) ($dateRange['from'] ?? ''));
        $to = trim((string) ($dateRange['to'] ?? ''));

        if ($field === '') {
            return;
        }

        if ($from !== '') {
            $model->where($field . ' >=', $from . ' 00:00:00');
        }

        if ($to !== '') {
            $model->where($field . ' <=', $to . ' 23:59:59');
        }
    }

    /**
     * Reads recent records for Dashboard widget widget_msyfedu3_7x619 through the concrete generated Model.
     *
     * The Model class is wired at generation-time; no runtime Model resolver is used.
     *
     * @param array<string,mixed> $filter
     * @param array<string,mixed> $dateRange
     * @param list<array<string,mixed>> $globalFilters
     * @param list<string> $fields
     * @return list<RecentRecord>
     */
    private function recentWidgetWidgetmsyfedu37x619(
        array $filter,
        array $dateRange,
        array $globalFilters,
        int $limit,
        array $fields,
        string $primaryKey
    ): array {
        $model = new FilmModel();
        $this->applyModelFilter($model, $filter);
        $this->applyModelDateRange($model, $dateRange);
        $this->applyModelFilters($model, $globalFilters);

        $records = $model
            ->orderBy($primaryKey, 'DESC')
            ->findAll(max(1, min(50, $limit)));

        $recordSources = [];
        foreach ($records as $record) {
            if (is_array($record)) {
                $recordSources[] = $record;
            } elseif (method_exists($record, 'toRawArray')) {
                $recordSources[] = $record->toRawArray();
            } elseif (method_exists($record, 'toArray')) {
                $recordSources[] = $record->toArray();
            } else {
                $recordSources[] = get_object_vars($record);
            }
        }

        $relationCacheLanguageId = [];
        foreach ($recordSources as &$recordSource) {
            $relationId = $recordSource['language_id'] ?? null;
            if ($relationId === null || $relationId === '') { continue; }
            $relationKey = (string) $relationId;
            if (!array_key_exists($relationKey, $relationCacheLanguageId)) {
                $option = $model->findLanguageIdOption($relationId);
                $relationCacheLanguageId[$relationKey] = is_array($option) ? (string) ($option['text'] ?? $relationKey) : $relationKey;
            }
            $recordSource['language_id'] = $relationCacheLanguageId[$relationKey];
        }
        unset($recordSource);
        $relationCacheOriginalLanguageId = [];
        foreach ($recordSources as &$recordSource) {
            $relationId = $recordSource['original_language_id'] ?? null;
            if ($relationId === null || $relationId === '') { continue; }
            $relationKey = (string) $relationId;
            if (!array_key_exists($relationKey, $relationCacheOriginalLanguageId)) {
                $option = $model->findOriginalLanguageIdOption($relationId);
                $relationCacheOriginalLanguageId[$relationKey] = is_array($option) ? (string) ($option['text'] ?? $relationKey) : $relationKey;
            }
            $recordSource['original_language_id'] = $relationCacheOriginalLanguageId[$relationKey];
        }
        unset($recordSource);

        return RecentRecord::collection($recordSources, $fields, $primaryKey);
    }
}