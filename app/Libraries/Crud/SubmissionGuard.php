<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

/**
 * Protegge i form CRUD dal doppio invio accidentale.
 * Ogni token è monouso e viene eliminato dalla sessione al primo consumo.
 */
final class SubmissionGuard
{
    public function create(string $action): string
    {
        $token = bin2hex(random_bytes(16));
        session()->set($this->key($action, $token), true);

        return $token;
    }

    public function consume(string $action, mixed $token): bool
    {
        $token = trim((string) $token);
        if ($token === '') {
            return false;
        }

        $key = $this->key($action, $token);
        if (!session()->has($key)) {
            return false;
        }

        session()->remove($key);

        return true;
    }

    private function key(string $action, string $token): string
    {
        return 'crud_submission_' . sha1($action) . '_' . $token;
    }
}