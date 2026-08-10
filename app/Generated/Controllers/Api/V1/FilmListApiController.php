<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\FilmListResource;
use App\Controllers\Api\BaseApiController;
use App\Services\FilmListService;
use App\Validation\FilmListApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa film_list. */
final class FilmListApiController extends BaseApiController
{
    public function __construct(private readonly FilmListService $service = new FilmListService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, FilmListResource::filterableFields(), FilmListResource::sortableFields());
            return $this->success(FilmListResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
