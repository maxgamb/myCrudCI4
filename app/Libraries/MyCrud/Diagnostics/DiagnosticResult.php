<?php

namespace App\Libraries\MyCrud\Diagnostics;

final class DiagnosticResult
{
    public const PASS = 'pass';
    public const WARN = 'warn';
    public const FAIL = 'fail';
    public const SKIP = 'skip';

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(
        public readonly string $name,
        public readonly string $status,
        public readonly string $message,
        public readonly array $context = [],
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'status'  => $this->status,
            'message' => $this->message,
            'context' => $this->context,
        ];
    }
}
