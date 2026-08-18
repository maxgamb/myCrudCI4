<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Film;

use App\API\Resources\FilmResource;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test della Resource REST: puro, senza accesso al database.
 */
final class FilmApiResourceContractTest extends CIUnitTestCase
{
    private const READABLE = array (
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
  14 => 'language_id__label',
  15 => 'original_language_id__label',
);

    public function testResourceMakeExposesOnlyReadableFields(): void
    {
        $source = [];
        foreach (self::READABLE as $field) {
            $source[$field] = 'readable-' . $field;
        }
        $source['__unknown_field__'] = 'must-not-survive';

        $result = FilmResource::make($source);

        $this->assertSame(
            array_values(self::READABLE),
            array_values(array_keys($result))
        );
        $this->assertArrayNotHasKey('__unknown_field__', $result);
    }

    public function testResourceIsOutputOnly(): void
    {
        $path = APPPATH . 'API/Resources/FilmResource.php';
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
