<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Film;

use App\Mcp\Resources\FilmMcpResource;
use CodeIgniter\Test\CIUnitTestCase;

final class FilmMcpResourceSecurityContractTest extends CIUnitTestCase
{
    private const EXPECTED_READABLE = array (
  0 => 'film_id',
  1 => 'title',
  2 => 'description',
  3 => 'release_year',
  4 => 'language_id',
  5 => 'original_language_id',
  6 => 'rental_duration',
  7 => 'rental_rate',
  8 => 'length',
  9 => 'replacement_cost',
  10 => 'rating',
  11 => 'special_features',
  12 => 'last_update',
  13 => 'uploads',
);

    public function testMcpResourceExposesOnlyMcpVisibleFields(): void
    {
        $source = [];
        foreach (self::EXPECTED_READABLE as $field) {
            $source[$field] = 'visible-' . $field;
        }
        $source['__not_mcp_visible__'] = 'must-not-survive';

        $result = FilmMcpResource::make($source);

        $this->assertSame(
            array_values(self::EXPECTED_READABLE),
            array_values(array_keys($result))
        );
        $this->assertArrayNotHasKey('__not_mcp_visible__', $result);
    }

    public function testMcpProjectionDoesNotDependOnApiResource(): void
    {
        $path = APPPATH . 'Mcp/Resources/FilmMcpResource.php';
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
