<?php

declare(strict_types=1);

namespace Tests\Generated\MyCrud\Address;

use CodeIgniter\Test\CIUnitTestCase;

/** Guards the generated REST architecture boundary. */
final class AddressApiArchitectureContractTest extends CIUnitTestCase
{
    public function testApiControllerUsesModelForReadsAndServiceForWritesWithoutSql(): void
    {
        $path = APPPATH . 'Controllers/Api/V1/AddressApiController.php';
        $this->assertFileExists($path);
        $php = (string) file_get_contents($path);

        $this->assertStringContainsString('private readonly AddressModel $model', $php);
        $this->assertStringContainsString('private readonly AddressService $service', $php);
        $this->assertStringContainsString('->patch($id, $data)', $php);
        $this->assertStringNotContainsString('Database::connect', $php);
        $this->assertStringNotContainsString('->db->', $php);
        $this->assertStringNotContainsString('->table(', $php);
        $this->assertDoesNotMatchRegularExpression('/new\s+\$[A-Za-z_]/', $php);
        $this->assertStringNotContainsString("['table']", $php);
    }

    public function testServiceExposesExplicitPatchAndUploadUseCasesWhenApplicable(): void
    {
        $service = (string) file_get_contents(APPPATH . 'Services/AddressService.php');
        $this->assertStringContainsString('public function patch(', $service);
        $this->assertTrue(true);
    }

    public function testResourceRemainsOutputOnly(): void
    {
        $resource = (string) file_get_contents(APPPATH . 'API/Resources/AddressResource.php');
        $this->assertStringNotContainsString('writableData(', $resource);
        $this->assertStringNotContainsString('filterableFields(', $resource);
        $this->assertStringNotContainsString('sortableFields(', $resource);
        $this->assertStringNotContainsString('FILTERABLE', $resource);
        $this->assertStringNotContainsString('SORTABLE', $resource);
        $this->assertStringNotContainsString('Database::connect', $resource);
        $this->assertStringNotContainsString('->db', $resource);
    }
}
