<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Actor;

use App\Mcp\Resources\ActorMcpResource;
use CodeIgniter\Test\CIUnitTestCase;

final class ActorMcpResourceSecurityContractTest extends CIUnitTestCase
{
    private const EXPECTED_READABLE = array (
  0 => 'actor_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'last_update',
);

    public function testMcpResourceExposesOnlyMcpVisibleFields(): void
    {
        $source = [];
        foreach (self::EXPECTED_READABLE as $field) {
            $source[$field] = 'visible-' . $field;
        }
        $source['__not_mcp_visible__'] = 'must-not-survive';

        $result = ActorMcpResource::make($source);

        $this->assertSame(
            array_values(self::EXPECTED_READABLE),
            array_values(array_keys($result))
        );
        $this->assertArrayNotHasKey('__not_mcp_visible__', $result);
    }

    public function testMcpProjectionDoesNotDependOnApiResource(): void
    {
        $path = APPPATH . 'Mcp/Resources/ActorMcpResource.php';
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
