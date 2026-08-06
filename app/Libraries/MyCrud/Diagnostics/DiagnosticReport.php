<?php

namespace App\Libraries\MyCrud\Diagnostics;

use JsonException;

final class DiagnosticReport
{
    /** @var list<DiagnosticResult> */
    private array $results = [];

    public function add(DiagnosticResult $result): void
    {
        $this->results[] = $result;
    }

    /** @param iterable<DiagnosticResult> $results */
    public function addMany(iterable $results): void
    {
        foreach ($results as $result) {
            $this->add($result);
        }
    }

    /** @return list<DiagnosticResult> */
    public function results(): array
    {
        return $this->results;
    }

    public function hasFailures(): bool
    {
        foreach ($this->results as $result) {
            if ($result->status === DiagnosticResult::FAIL) {
                return true;
            }
        }

        return false;
    }

    /** @return array<string, int> */
    public function summary(): array
    {
        $summary = [
            DiagnosticResult::PASS => 0,
            DiagnosticResult::WARN => 0,
            DiagnosticResult::FAIL => 0,
            DiagnosticResult::SKIP => 0,
        ];

        foreach ($this->results as $result) {
            $summary[$result->status] = ($summary[$result->status] ?? 0) + 1;
        }

        return $summary;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'generatedAt' => date(DATE_ATOM),
            'summary'     => $this->summary(),
            'results'     => array_map(
                static fn (DiagnosticResult $result): array => $result->toArray(),
                $this->results
            ),
        ];
    }

    /** @throws JsonException */
    public function toJson(): string
    {
        return json_encode(
            $this->toArray(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        );
    }
}
