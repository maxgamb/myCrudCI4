<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Actor;

use CodeIgniter\Test\CIUnitTestCase;

final class ActorMcpFoundationContractTest extends CIUnitTestCase
{
    private const EXPECTED_TOOLS = array (
  0 => 'list_actor',
  1 => 'get_actor',
);

    public function testPublishedMcpManifestDeclaresReadOnlyTools(): void
    {
        $path = APPPATH . 'Mcp/Manifests/actor.json';
        $this->assertFileExists($path);

        $manifest = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame('myCrudCI4-mcp-foundation', $manifest['format'] ?? null);
        $this->assertSame('2026-07-28', $manifest['targetProtocol'] ?? null);
        $this->assertSame('stdio', $manifest['server']['transport'] ?? null);
        $this->assertSame('read_only', $manifest['server']['mode'] ?? null);
        $this->assertSame(self::EXPECTED_TOOLS, $manifest['mcp']['tools'] ?? []);
        $this->assertSame(self::EXPECTED_TOOLS !== [], (bool) ($manifest['mcp']['toolsGenerated'] ?? false));
    }

    public function testPublishedReadOnlyToolsUseModelLayer(): void
    {
        $path = APPPATH . 'Mcp/Tools/ActorTools.php';
        $this->assertFileExists($path);

        $php = (string) file_get_contents($path);
        $this->assertStringContainsString('McpTool', $php);
        $this->assertStringContainsString('App\\Models\\', $php);
        $this->assertStringNotContainsString('Database::connect', $php);
        $this->assertStringNotContainsString('db_connect(', $php);

    }
}
