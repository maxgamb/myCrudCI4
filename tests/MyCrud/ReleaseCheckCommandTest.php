<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class ReleaseCheckCommandTest extends TestCase
{
    public function testReleaseCheckCommandComposesExistingGates(): void
    {
        $code = (string) file_get_contents(APPPATH . 'Commands/MyCrudReleaseCheck.php');

        self::assertStringContainsString("protected \$name = 'mycrud:release-check';", $code);
        self::assertStringContainsString("mycrud:test-all", $code);
        self::assertStringContainsString("mycrud:test-generated", $code);
        self::assertStringContainsString("mycrud:check-api", $code);
        self::assertStringContainsString("mycrud:check-query-layer", $code);
        self::assertStringContainsString("mycrud:test-dashboard", $code);
        self::assertStringContainsString('ShieldCrudApiSeparationTest.php', $code);
        self::assertStringContainsString('CliDocumentationCoverageTest.php', $code);
        self::assertStringContainsString('READY FOR RC1', $code);
    }
}
