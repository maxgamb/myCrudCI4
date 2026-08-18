<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\ActorInfoResource;
use App\Controllers\Api\BaseApiController;
use App\Models\ActorInfoModel;
use App\Services\ActorInfoService;
use Throwable;

/**
 * Read-only API for SQL VIEW `actor_info`.
 * Exposes only GET operations compatible with generated capabilities.
 * READ operations are delegated to the generated Model; no SQL is composed here.
 */
final class ActorInfoApiController extends BaseApiController
{
    /** Fields accepted as REST list filters. API query policy belongs to the HTTP boundary. */
    private const FILTERABLE_FIELDS = array (
);

    /** Fields accepted for REST list sorting. API query policy belongs to the HTTP boundary. */
    private const SORTABLE_FIELDS = array (
  0 => 'actor_id',
);

    /** Fields accepted from REST JSON/form request bodies. Binary upload fields are intentionally excluded. */
    private const WRITABLE_FIELDS = array (
);

    public function __construct(
        private readonly ActorInfoModel $model = new ActorInfoModel(),
        private readonly ActorInfoService $service = new ActorInfoService()
    ) {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->model->apiList($query, self::FILTERABLE_FIELDS, self::SORTABLE_FIELDS);
            return $this->success(ActorInfoResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }
}
