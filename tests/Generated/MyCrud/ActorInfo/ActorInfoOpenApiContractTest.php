<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\ActorInfo;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * Verifies the published OpenAPI contract without requiring external YAML parsers.
 */
final class ActorInfoOpenApiContractTest extends CIUnitTestCase
{
    private const EXPECTED_OPERATION_IDS = array (
  0 => 'listActorInfo',
);

    public function testOpenApiFileContainsExpectedOperations(): void
    {
        $path = APPPATH . 'OpenApi/actor_info.yaml';

        $this->assertFileExists($path);

        $yaml = (string) file_get_contents($path);
        $this->assertStringContainsString('openapi: 3.0.3', $yaml);
        $this->assertStringContainsString('/api/v1/actor_info', $yaml);

        foreach (self::EXPECTED_OPERATION_IDS as $operationId) {
            $this->assertStringContainsString(
                'operationId: ' . $operationId,
                $yaml,
                'operationId OpenAPI mancante: ' . $operationId
            );
        }

        // Web Related Create/Offcanvas transport is intentionally not part of REST.
        $this->assertStringNotContainsString('_related_new', $yaml);
        $this->assertStringNotContainsString('_related:', $yaml);
        $this->assertStringNotContainsString('_many_new', $yaml);
        $this->assertStringNotContainsString('_many_related', $yaml);
        $this->assertStringNotContainsString('offcanvas', strtolower($yaml));
    }
}
