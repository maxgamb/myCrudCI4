<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\ListinoObmpResource;
use App\Controllers\Api\BaseApiController;
use App\Services\ListinoObmpService;
use App\Validation\ListinoObmpApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa listino_obmp. */
final class ListinoObmpApiController extends BaseApiController
{
    public function __construct(private readonly ListinoObmpService $service = new ListinoObmpService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, ListinoObmpResource::filterableFields(), ListinoObmpResource::sortableFields());
            return $this->success(ListinoObmpResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }

    public function show(int|string $id)
    {
        try {
            return $this->success(ListinoObmpResource::make($this->service->find($id)));
        } catch (RuntimeException) {
            return $this->error('NOT_FOUND', 'Record non trovato.', 404);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }

    public function create()
    {
        $data = ListinoObmpResource::writableData($this->payload());
        if ($data === []) {
            return $this->error('EMPTY_PAYLOAD', 'Nessun campo scrivibile ricevuto.', 422);
        }
        if (!$this->validateData($data, ListinoObmpApiRules::createRules(), ListinoObmpApiRules::messages())) {
            return $this->error('VALIDATION_ERROR', 'Dati non validi.', 422, $this->validator->getErrors());
        }
        try {
            $id = $this->service->create($data);
            return $this->success(['listino_id' => $id], [], [], 201);
        } catch (RuntimeException $e) {
            return $this->error('CREATE_FAILED', $e->getMessage(), 400);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }

    public function update(int|string $id)
    {
        return $this->writeUpdate($id, false);
    }

    public function patch(int|string $id)
    {
        return $this->writeUpdate($id, true);
    }

    private function writeUpdate(int|string $id, bool $partial)
    {
        $data = ListinoObmpResource::writableData($this->payload());
        unset($data['listino_id']);
        if ($data === []) {
            return $this->error('EMPTY_PAYLOAD', 'Nessun campo scrivibile ricevuto.', 422);
        }

        $rules = ListinoObmpApiRules::updateRules($id);
        if ($partial) {
            $rules = array_intersect_key($rules, $data);
        }
        if ($rules !== [] && !$this->validateData($data, $rules, ListinoObmpApiRules::messages())) {
            return $this->error('VALIDATION_ERROR', 'Dati non validi.', 422, $this->validator->getErrors());
        }

        try {
            $this->service->find($id);
            $this->service->update($id, $data);
            return $this->success(ListinoObmpResource::make($this->service->find($id)));
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'Record non trovato.') {
                return $this->error('NOT_FOUND', 'Record non trovato.', 404);
            }
            return $this->error('UPDATE_FAILED', $e->getMessage(), 400);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }

    public function delete(int|string $id)
    {
        try {
            $this->service->find($id);
            $this->service->delete($id);
            return $this->response->setStatusCode(204)->setBody('');
        } catch (RuntimeException $e) {
            if ($e->getMessage() === 'Record non trovato.') {
                return $this->error('NOT_FOUND', 'Record non trovato.', 404);
            }
            return $this->error('DELETE_FAILED', $e->getMessage(), 400);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }
}
