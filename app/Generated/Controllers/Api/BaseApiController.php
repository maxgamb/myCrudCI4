<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

/**
 * Base comune delle API generate.
 * Standardizes payloads, errors, and pagination limits.
 */
abstract class BaseApiController extends BaseController
{
    protected int $maxPerPage = 100;

    protected function success(
        mixed $data,
        array $meta = [],
        array $links = [],
        int $status = 200
    ): ResponseInterface {
        return $this->response->setStatusCode($status)->setJSON([
            'data'  => $data,
            'meta'  => (object) $meta,
            'links' => (object) $links,
        ]);
    }

    protected function error(
        string $code,
        string $message,
        int $status,
        array $fields = []
    ): ResponseInterface {
        $error = [
            'code'    => $code,
            'message' => $message,
        ];

        if ($fields !== []) {
            $error['fields'] = $fields;
        }

        return $this->response
            ->setStatusCode($status)
            ->setJSON(['error' => $error]);
    }

    protected function payload(): array
    {
        $json = $this->request->getJSON(true);

        if (is_array($json)) {
            return $json;
        }

        $raw = $this->request->getRawInput();

        return is_array($raw) && $raw !== []
            ? $raw
            : (array) $this->request->getPost();
    }

    protected function safePerPage(int $default = 25): int
    {
        $requested = (int) ($this->request->getGet('perPage') ?? $default);

        return max(1, min($this->maxPerPage, $requested));
    }

    protected function internalError(Throwable $exception): ResponseInterface
    {
        log_message('error', '[API] {message} in {file}:{line}', [
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
        ]);

        return $this->error(
            'INTERNAL_ERROR',
            'Internal server error.',
            500
        );
    }
}
