<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\NicerButSlowerFilmListResource;
use App\Controllers\Api\BaseApiController;
use App\Services\NicerButSlowerFilmListService;
use App\Validation\NicerButSlowerFilmListApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa nicer_but_slower_film_list. */
final class NicerButSlowerFilmListApiController extends BaseApiController
{
    public function __construct(private readonly NicerButSlowerFilmListService $service = new NicerButSlowerFilmListService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, NicerButSlowerFilmListResource::filterableFields(), NicerButSlowerFilmListResource::sortableFields());
            return $this->success(NicerButSlowerFilmListResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
