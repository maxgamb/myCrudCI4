<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use PHPUnit\Framework\TestCase;

final class PublishManagedArtifactsTest extends TestCase
{
    public function testPublishKeepsGeneratedTestsAndMcpArtifactsSynchronized(): void
    {
        $path = dirname(__DIR__, 2) . '/app/Libraries/MyCrud/Core/CrudPublishService.php';
        self::assertFileExists($path);
        $php = (string) file_get_contents($path);

        self::assertStringContainsString("str_starts_with(\$relative, 'Tests/')", $php);
        self::assertStringContainsString("str_starts_with(\$relative, 'Mcp/')", $php);
        self::assertStringContainsString('synchronizeStaleMcpArtifacts(', $php);
        self::assertStringContainsString("'Mcp/Manifests/' . \$table . '.json'", $php);
        self::assertStringContainsString("'Mcp/Tools/' . \$resource . 'Tools.php'", $php);
        self::assertStringContainsString("'Mcp/Tools/' . \$resource . 'RelationTools.php'", $php);
        self::assertStringContainsString("'Mcp/Resources/' . \$resource . 'McpResource.php'", $php);
        self::assertStringContainsString("'stale_managed_mcp_artifact'", $php);
    }
}
