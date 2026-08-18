<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Country;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * Verifies the published OpenAPI contract without requiring external YAML parsers.
 */
final class CountryOpenApiContractTest extends CIUnitTestCase
{
    private const EXPECTED_OPERATION_IDS = array (
  0 => 'listCountry',
  1 => 'getCountry',
  2 => 'createCountry',
  3 => 'updateCountry',
  4 => 'deleteCountry',
  5 => 'patchCountry',
);

    public function testOpenApiFileContainsExpectedOperations(): void
    {
        $path = APPPATH . 'OpenApi/country.yaml';

        $this->assertFileExists($path);

        $yaml = (string) file_get_contents($path);
        $this->assertStringContainsString('openapi: 3.0.3', $yaml);
        $this->assertStringContainsString('/api/v1/country', $yaml);

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
