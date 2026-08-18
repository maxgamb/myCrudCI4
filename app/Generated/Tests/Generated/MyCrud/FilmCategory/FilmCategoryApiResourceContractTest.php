<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\FilmCategory;

use App\API\Resources\FilmCategoryResource;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test della Resource REST: puro, senza accesso al database.
 */
final class FilmCategoryApiResourceContractTest extends CIUnitTestCase
{
    private const READABLE = array (
  0 => 'film_id',
  1 => 'category_id',
  2 => 'last_update',
  3 => 'category_id__label',
  4 => 'film_id__label',
);

    public function testResourceMakeExposesOnlyReadableFields(): void
    {
        $source = [];
        foreach (self::READABLE as $field) {
            $source[$field] = 'readable-' . $field;
        }
        $source['__unknown_field__'] = 'must-not-survive';

        $result = FilmCategoryResource::make($source);

        $this->assertSame(
            array_values(self::READABLE),
            array_values(array_keys($result))
        );
        $this->assertArrayNotHasKey('__unknown_field__', $result);
    }

    public function testResourceIsOutputOnly(): void
    {
        $path = APPPATH . 'API/Resources/FilmCategoryResource.php';
        $php = (string) file_get_contents($path);

        $this->assertStringNotContainsString('writableData(', $php);
        $this->assertStringNotContainsString('filterableFields(', $php);
        $this->assertStringNotContainsString('sortableFields(', $php);
        $this->assertStringNotContainsString('FILTERABLE', $php);
        $this->assertStringNotContainsString('SORTABLE', $php);
        $this->assertStringNotContainsString('Database::connect', $php);
        $this->assertStringNotContainsString('->db', $php);
        $this->assertStringNotContainsString('App\\Models', $php);
        $this->assertStringNotContainsString('App\\Services', $php);
    }
}
