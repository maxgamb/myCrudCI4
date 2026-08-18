<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Rental;

use App\Mcp\Resources\RentalMcpResource;
use CodeIgniter\Test\CIUnitTestCase;

final class RentalMcpResourceSecurityContractTest extends CIUnitTestCase
{
    private const EXPECTED_READABLE = array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'return_date',
  5 => 'staff_id',
  6 => 'last_update',
);

    public function testMcpResourceExposesOnlyMcpVisibleFields(): void
    {
        $source = [];
        foreach (self::EXPECTED_READABLE as $field) {
            $source[$field] = 'visible-' . $field;
        }
        $source['__not_mcp_visible__'] = 'must-not-survive';

        $result = RentalMcpResource::make($source);

        $this->assertSame(
            array_values(self::EXPECTED_READABLE),
            array_values(array_keys($result))
        );
        $this->assertArrayNotHasKey('__not_mcp_visible__', $result);
    }

    public function testMcpProjectionDoesNotDependOnApiResource(): void
    {
        $path = APPPATH . 'Mcp/Resources/RentalMcpResource.php';
        $this->assertFileExists($path);

        $php = (string) file_get_contents($path);
        $this->assertStringNotContainsString('App\\API\\Resources', $php);
        $this->assertStringNotContainsString('apiVisible', $php);
        $this->assertStringNotContainsString('FILTERABLE', $php);
        $this->assertStringNotContainsString('SORTABLE', $php);
        $this->assertStringNotContainsString('filterableFields(', $php);
        $this->assertStringNotContainsString('sortableFields(', $php);
    }
}
