<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\SalesByStoreResource;
use App\Controllers\Api\BaseApiController;
use App\Models\SalesByStoreModel;
use App\Services\SalesByStoreService;
use Throwable;

/**
 * Read-only API for SQL VIEW `sales_by_store`.
 * Exposes only GET operations compatible with generated capabilities.
 * READ operations are delegated to the generated Model; no SQL is composed here.
 */
final class SalesByStoreApiController extends BaseApiController
{
    /** Fields accepted as REST list filters. API query policy belongs to the HTTP boundary. */
    private const FILTERABLE_FIELDS = array (
);

    /** Fields accepted for REST list sorting. API query policy belongs to the HTTP boundary. */
    private const SORTABLE_FIELDS = array (
  0 => 'store',
);

    /** Fields accepted from REST JSON/form request bodies. Binary upload fields are intentionally excluded. */
    private const WRITABLE_FIELDS = array (
);

    public function __construct(
        private readonly SalesByStoreModel $model = new SalesByStoreModel(),
        private readonly SalesByStoreService $service = new SalesByStoreService()
    ) {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->model->apiList($query, self::FILTERABLE_FIELDS, self::SORTABLE_FIELDS);
            return $this->success(SalesByStoreResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }
}
