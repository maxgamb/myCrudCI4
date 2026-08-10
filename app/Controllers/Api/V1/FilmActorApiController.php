<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\FilmActorResource;
use App\Controllers\Api\BaseApiController;
use App\Services\FilmActorService;
use App\Validation\FilmActorApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa film_actor. */
final class FilmActorApiController extends BaseApiController
{
    public function __construct(private readonly FilmActorService $service = new FilmActorService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, FilmActorResource::filterableFields(), FilmActorResource::sortableFields());
            return $this->success(FilmActorResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
