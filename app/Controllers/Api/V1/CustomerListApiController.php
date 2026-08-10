<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\CustomerListResource;
use App\Controllers\Api\BaseApiController;
use App\Services\CustomerListService;
use App\Validation\CustomerListApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa customer_list. */
final class CustomerListApiController extends BaseApiController
{
    public function __construct(private readonly CustomerListService $service = new CustomerListService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, CustomerListResource::filterableFields(), CustomerListResource::sortableFields());
            return $this->success(CustomerListResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
