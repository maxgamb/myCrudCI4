<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class CliDocumentationCoverageTest extends TestCase
{
    public function testCliDocumentationListsEveryRegisteredMyCrudCommand(): void
    {
        $root = dirname(__DIR__, 2);
        $commandFiles = glob($root . '/app/Commands/MyCrud*.php') ?: [];
        $registered = [];

        foreach ($commandFiles as $file) {
            $source = (string) file_get_contents($file);
            if (preg_match('/protected\s+\x24name\s*=\s*\x27([^\x27]+)\x27/', $source, $match) !== 1) {
                continue;
            }
            if (str_starts_with($match[1], 'mycrud:')) {
                $registered[] = $match[1];
            }
        }

        sort($registered);
        $this->assertCount(19, $registered);

        $documentation = (string) file_get_contents($root . '/docs/CLI.md');
        preg_match_all('/### `(?<name>mycrud:[a-z0-9-]+)`/', $documentation, $matches);
        $documented = array_values(array_unique($matches['name'] ?? []));
        sort($documented);

        $this->assertSame($registered, $documented);
        $this->assertContains('mycrud:test-dashboard', $documented);
    }
}
