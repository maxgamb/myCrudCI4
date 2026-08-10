<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\StaffListResource;
use App\Controllers\Api\BaseApiController;
use App\Services\StaffListService;
use App\Validation\StaffListApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa staff_list. */
final class StaffListApiController extends BaseApiController
{
    public function __construct(private readonly StaffListService $service = new StaffListService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, StaffListResource::filterableFields(), StaffListResource::sortableFields());
            return $this->success(StaffListResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
