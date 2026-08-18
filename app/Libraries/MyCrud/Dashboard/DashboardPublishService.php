<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Dashboard;

use RuntimeException;

final class DashboardPublishService
{
    /** @var list<string> */
    private const FILES = [
        'DTO/Dashboard/Kpi.php',
        'DTO/Dashboard/SeriesPoint.php',
        'DTO/Dashboard/RecentRecord.php',
        'DTO/Dashboard/DashboardWidget.php',
        'DTO/Dashboard/DashboardData.php',
        'Libraries/Dashboard/DashboardQuery.php',
        'Services/DashboardService.php',
        'Controllers/DashboardController.php',
        'Views/dashboard/index.php',
        'Routes/dashboard.php',
    ];

    public function publish(bool $force = false, bool $dryRun = false): array
    {
        $staging = APPPATH . 'Generated' . DIRECTORY_SEPARATOR;
        $rows = [];

        foreach (self::FILES as $relative) {
            $source = $staging . str_replace('/', DIRECTORY_SEPARATOR, $relative);
            $target = APPPATH . str_replace('/', DIRECTORY_SEPARATOR, $relative);

            if (!is_file($source)) {
                $rows[$relative] = 'missing';
                continue;
            }

            if (is_file($target) && hash_file('sha256', $source) === hash_file('sha256', $target)) {
                $rows[$relative] = 'unchanged';
                continue;
            }

            if (is_file($target) && !$force) {
                $rows[$relative] = 'skipped';
                continue;
            }

            if ($dryRun) {
                $rows[$relative] = is_file($target) ? 'would_overwrite' : 'would_create';
                continue;
            }

            $dir = dirname($target);
            if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new RuntimeException('Unable to create Dashboard target directory.');
            }

            $tmp = $target . '.mycrud-dashboard-' . bin2hex(random_bytes(4));
            if (!copy($source, $tmp) || !rename($tmp, $target)) {
                @unlink($tmp);
                throw new RuntimeException('Unable to publish Dashboard file: ' . $relative);
            }

            $rows[$relative] = is_file($target) ? 'published' : 'failed';
        }

        return $rows;
    }
}
