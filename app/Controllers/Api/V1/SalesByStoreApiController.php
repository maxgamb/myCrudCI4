<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\SalesByStoreResource;
use App\Controllers\Api\BaseApiController;
use App\Services\SalesByStoreService;
use App\Validation\SalesByStoreApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa sales_by_store. */
final class SalesByStoreApiController extends BaseApiController
{
    public function __construct(private readonly SalesByStoreService $service = new SalesByStoreService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, SalesByStoreResource::filterableFields(), SalesByStoreResource::sortableFields());
            return $this->success(SalesByStoreResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
