<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\ActorInfoResource;
use App\Controllers\Api\BaseApiController;
use App\Services\ActorInfoService;
use App\Validation\ActorInfoApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa actor_info. */
final class ActorInfoApiController extends BaseApiController
{
    public function __construct(private readonly ActorInfoService $service = new ActorInfoService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, ActorInfoResource::filterableFields(), ActorInfoResource::sortableFields());
            return $this->success(ActorInfoResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
