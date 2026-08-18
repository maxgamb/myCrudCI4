<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\DashboardService;
use DateTimeImmutable;

final class DashboardController extends BaseController
{
    public function index(): string
    {
        $dateRange = [
            'from' => $this->validDate((string) $this->request->getGet('from')),
            'to' => $this->validDate((string) $this->request->getGet('to')),
        ];

        if ($dateRange['from'] !== '' && $dateRange['to'] !== '' && $dateRange['from'] > $dateRange['to']) {
            [$dateRange['from'], $dateRange['to']] = [$dateRange['to'], $dateRange['from']];
        }

        $dashboard = (new DashboardService())->build(
            $dateRange,
            $this->globalValues()
        );

        return view('dashboard/index', [
            'title' => $dashboard->title,
            'dashboard' => $dashboard,
        ]);
    }

    /** @return array<string,string> */
    private function globalValues(): array
    {
        $values = [];

        foreach ((array) $this->request->getGet() as $key => $value) {
            $key = (string) $key;

            if (!str_starts_with($key, 'gf_') || !is_scalar($value)) {
                continue;
            }

            $id = substr($key, 3);
            if ($id === '' || preg_match('/^[A-Za-z][A-Za-z0-9_]*$/D', $id) !== 1) {
                continue;
            }

            $values[$id] = mb_substr(trim((string) $value), 0, 255);
        }

        return $values;
    }

    private function validDate(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }

        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        $errors = DateTimeImmutable::getLastErrors();

        if ($date === false) {
            return '';
        }

        if (is_array($errors) && (($errors['warning_count'] ?? 0) > 0 || ($errors['error_count'] ?? 0) > 0)) {
            return '';
        }

        return $date->format('Y-m-d') === $value ? $value : '';
    }
}