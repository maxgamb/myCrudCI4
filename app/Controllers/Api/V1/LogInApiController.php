<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

use App\API\Resources\LogInResource;
use App\Controllers\Api\BaseApiController;
use App\Services\LogInService;
use App\Validation\LogInApiRules;
use RuntimeException;
use Throwable;

/** API REST v1 per la risorsa log_in. */
final class LogInApiController extends BaseApiController
{
    public function __construct(private readonly LogInService $service = new LogInService())
    {
    }

    public function index()
    {
        try {
            $query = (array) $this->request->getGet();
            $query['perPage'] = $this->safePerPage();
            $result = $this->service->apiList($query, LogInResource::filterableFields(), LogInResource::sortableFields());
            return $this->success(LogInResource::collection($result['rows']), $result['meta'], $result['links']);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }

    public function show(int|string $id)
    {
        try {
            return $this->success(LogInResource::make($this->service->find($id)));
        } catch (RuntimeException) {
            return $this->error('NOT_FOUND', 'Record non trovato.', 404);
        } catch (Throwable $e) {
            return $this->internalError($e);
        }
    }

    public function create()
    {
        $data = LogInResource::writableData($this->payload());
        if ($data === []) {
            return $this->error('EMPTY_PAYLOAD', 'Nessun campo scrivibile ricevuto.', 422);
        }
        if (!$this->validateData($data, LogInApiRules::createRules(), LogInApiRules::messages())) {
            return $this->error('VALIDATION_ERROR', 'Dati non validi.', 422, $this->validator->getErrors());
        }
        try {
            $id = $this->service->create($data);
            return $this->success(['log_in_id' => $id], [], [], 201);
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
        $data = LogInResource::writableData($this->payload());
        unset($data['log_in_id']);
        if ($data === []) {
            return $this->error('EMPTY_PAYLOAD', 'Nessun campo scrivibile ricevuto.', 422);
        }

        $rules = LogInApiRules::updateRules($id);
        if ($partial) {
            $rules = array_intersect_key($rules, $data);
        }
        if ($rules !== [] && !$this->validateData($data, $rules, LogInApiRules::messages())) {
            return $this->error('VALIDATION_ERROR', 'Dati non validi.', 422, $this->validator->getErrors());
        }

        try {
            $this->service->find($id);
            $this->service->update($id, $data);
            return $this->success(LogInResource::make($this->service->find($id)));
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
