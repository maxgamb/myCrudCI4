<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Rental;

use CodeIgniter\Test\CIUnitTestCase;

final class RentalMcpFoundationContractTest extends CIUnitTestCase
{
    private const EXPECTED_TOOLS = array (
  0 => 'list_rental',
  1 => 'get_rental',
  2 => 'get_rental_customer_id',
  3 => 'get_rental_inventory_id',
  4 => 'get_rental_staff_id',
  5 => 'list_rental_payment_by_rental_id',
);

    public function testPublishedMcpManifestDeclaresReadOnlyTools(): void
    {
        $path = APPPATH . 'Mcp/Manifests/rental.json';
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
        $path = APPPATH . 'Mcp/Tools/RentalTools.php';
        $this->assertFileExists($path);

        $php = (string) file_get_contents($path);
        $this->assertStringContainsString('McpTool', $php);
        $this->assertStringContainsString('App\\Models\\', $php);
        $this->assertStringNotContainsString('Database::connect', $php);
        $this->assertStringNotContainsString('db_connect(', $php);

        $relationPath = APPPATH . 'Mcp/Tools/RentalRelationTools.php';
        $this->assertFileExists($relationPath);

        $relationPhp = (string) file_get_contents($relationPath);
        $this->assertStringContainsString('McpTool', $relationPhp);
        $this->assertStringContainsString('App\\Models\\', $relationPhp);
        $this->assertStringNotContainsString('Database::connect', $relationPhp);
        $this->assertStringNotContainsString('db_connect(', $relationPhp);    }
}
