<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Staff;

use CodeIgniter\Test\CIUnitTestCase;

final class StaffMcpFoundationContractTest extends CIUnitTestCase
{
    private const EXPECTED_TOOLS = array (
  0 => 'list_staff',
  1 => 'get_staff',
  2 => 'get_staff_address_id',
  3 => 'get_staff_store_id',
  4 => 'list_staff_payment_by_staff_id',
  5 => 'list_staff_rental_by_staff_id',
  6 => 'list_staff_store_by_manager_staff_id',
);

    public function testPublishedMcpManifestDeclaresReadOnlyTools(): void
    {
        $path = APPPATH . 'Mcp/Manifests/staff.json';
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
        $path = APPPATH . 'Mcp/Tools/StaffTools.php';
        $this->assertFileExists($path);

        $php = (string) file_get_contents($path);
        $this->assertStringContainsString('McpTool', $php);
        $this->assertStringContainsString('App\\Models\\', $php);
        $this->assertStringNotContainsString('Database::connect', $php);
        $this->assertStringNotContainsString('db_connect(', $php);

        $relationPath = APPPATH . 'Mcp/Tools/StaffRelationTools.php';
        $this->assertFileExists($relationPath);

        $relationPhp = (string) file_get_contents($relationPath);
        $this->assertStringContainsString('McpTool', $relationPhp);
        $this->assertStringContainsString('App\\Models\\', $relationPhp);
        $this->assertStringNotContainsString('Database::connect', $relationPhp);
        $this->assertStringNotContainsString('db_connect(', $relationPhp);    }
}
