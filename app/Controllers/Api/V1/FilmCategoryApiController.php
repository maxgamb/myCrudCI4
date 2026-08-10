<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\FilmCategoryResource;
use App\Controllers\Api\BaseApiController;
use App\Services\FilmCategoryService;
use App\Validation\FilmCategoryApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa film_category. */
final class FilmCategoryApiController extends BaseApiController
{
    public function __construct(private readonly FilmCategoryService $service = new FilmCategoryService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, FilmCategoryResource::filterableFields(), FilmCategoryResource::sortableFields());
            return $this->success(FilmCategoryResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
