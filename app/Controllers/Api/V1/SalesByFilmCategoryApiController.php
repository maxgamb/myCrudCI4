<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\SalesByFilmCategoryResource;
use App\Controllers\Api\BaseApiController;
use App\Services\SalesByFilmCategoryService;
use App\Validation\SalesByFilmCategoryApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa sales_by_film_category. */
final class SalesByFilmCategoryApiController extends BaseApiController
{
    public function __construct(private readonly SalesByFilmCategoryService $service = new SalesByFilmCategoryService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, SalesByFilmCategoryResource::filterableFields(), SalesByFilmCategoryResource::sortableFields());
            return $this->success(SalesByFilmCategoryResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }


}
