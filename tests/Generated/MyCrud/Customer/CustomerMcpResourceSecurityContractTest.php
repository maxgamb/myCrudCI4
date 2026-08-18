<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Customer;

use App\Mcp\Resources\CustomerMcpResource;
use CodeIgniter\Test\CIUnitTestCase;

final class CustomerMcpResourceSecurityContractTest extends CIUnitTestCase
{
    private const EXPECTED_READABLE = array (
  0 => 'customer_id',
  1 => 'store_id',
  2 => 'first_name',
  3 => 'last_name',
  4 => 'email',
  5 => 'address_id',
  6 => 'active',
  7 => 'create_date',
  8 => 'last_update',
);

    public function testMcpResourceExposesOnlyMcpVisibleFields(): void
    {
        $source = [];
        foreach (self::EXPECTED_READABLE as $field) {
            $source[$field] = 'visible-' . $field;
        }
        $source['__not_mcp_visible__'] = 'must-not-survive';

        $result = CustomerMcpResource::make($source);

        $this->assertSame(
            array_values(self::EXPECTED_READABLE),
            array_values(array_keys($result))
        );
        $this->assertArrayNotHasKey('__not_mcp_visible__', $result);
    }

    public function testMcpProjectionDoesNotDependOnApiResource(): void
    {
        $path = APPPATH . 'Mcp/Resources/CustomerMcpResource.php';
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
