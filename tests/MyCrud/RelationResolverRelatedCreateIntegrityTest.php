<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use App\Libraries\MyCrud\Core\RelationResolver;
use App\Libraries\MyCrud\Schema\DbSchema;
use Config\MyCrud;
use PHPUnit\Framework\TestCase;

final class RelationResolverRelatedCreateIntegrityTest extends TestCase
{
    public function testSpatialRequiredFieldDoesNotDisableRelatedCreate(): void
    {
        $resolver = new RelationResolver($this->customerAddressSchema(), new MyCrud());
        $relations = $resolver->resolve('customer');
        $address = (array) (($relations['belongsTo']['address_id'] ?? []));
        $definition = (array) ($address['relatedCreate'] ?? []);

        self::assertTrue((bool) ($definition['available'] ?? false));
        self::assertSame('', (string) ($definition['unavailableReason'] ?? ''));
        self::assertTrue((bool) ($definition['fields']['location']['spatial'] ?? false));
        self::assertSame('POINT(0 0)', $definition['fields']['location']['attributes']['values']['placeholder'] ?? null);

        $city = (array) ($definition['fields']['city_id']['foreignKey'] ?? []);
        self::assertSame('city', $city['parentTable'] ?? null);
        self::assertSame('city_id', $city['parentKey'] ?? null);
        self::assertSame('select', $city['optionMode'] ?? null);
    }

    public function testUniqueNestedForeignKeyMetadataIsPreserved(): void
    {
        $resolver = new RelationResolver($this->customerStoreSchema(), new MyCrud());
        $relations = $resolver->resolve('customer');
        $store = (array) (($relations['belongsTo']['store_id'] ?? []));
        $definition = (array) ($store['relatedCreate'] ?? []);
        $manager = (array) ($definition['fields']['manager_staff_id'] ?? []);

        self::assertTrue((bool) ($definition['available'] ?? false));
        self::assertTrue((bool) ($manager['unique'] ?? false));
        self::assertSame('staff', $manager['foreignKey']['parentTable'] ?? null);
        self::assertSame('select', $manager['foreignKey']['optionMode'] ?? null);
    }

    private function customerAddressSchema(): DbSchema
    {
        $customer = [
            'primaryKey' => 'customer_id', 'primaryKeys' => ['customer_id'], 'isView' => false,
            'columns' => [
                $this->column('customer_id', 'smallint', false, 'auto_increment', 'PRI'),
                $this->column('address_id', 'smallint', false),
            ],
            'foreignKeys' => [[
                'childColumn' => 'address_id', 'parentTable' => 'address', 'parentColumn' => 'address_id',
            ]],
        ];
        $address = [
            'primaryKey' => 'address_id', 'primaryKeys' => ['address_id'], 'isView' => false,
            'columns' => [
                $this->column('address_id', 'smallint', false, 'auto_increment', 'PRI'),
                $this->column('address', 'varchar', false),
                $this->column('district', 'varchar', false),
                $this->column('city_id', 'smallint', false),
                $this->column('location', 'geometry', false),
            ],
            'foreignKeys' => [[
                'childColumn' => 'city_id', 'parentTable' => 'city', 'parentColumn' => 'city_id',
            ]],
        ];
        $city = [
            'primaryKey' => 'city_id', 'primaryKeys' => ['city_id'], 'rowEstimate' => 600, 'isView' => false,
            'columns' => [
                $this->column('city_id', 'smallint', false, 'auto_increment', 'PRI'),
                $this->column('city', 'varchar', false),
            ],
            'foreignKeys' => [],
        ];

        return $this->schemaStub(['customer' => $customer, 'address' => $address, 'city' => $city], 'customer');
    }

    private function customerStoreSchema(): DbSchema
    {
        $customer = [
            'primaryKey' => 'customer_id', 'primaryKeys' => ['customer_id'], 'isView' => false,
            'columns' => [
                $this->column('customer_id', 'smallint', false, 'auto_increment', 'PRI'),
                $this->column('store_id', 'tinyint', false),
            ],
            'foreignKeys' => [[
                'childColumn' => 'store_id', 'parentTable' => 'store', 'parentColumn' => 'store_id',
            ]],
        ];
        $store = [
            'primaryKey' => 'store_id', 'primaryKeys' => ['store_id'], 'isView' => false,
            'columns' => [
                $this->column('store_id', 'tinyint', false, 'auto_increment', 'PRI'),
                $this->column('manager_staff_id', 'tinyint', false, '', 'UNI'),
                $this->column('address_id', 'smallint', false),
            ],
            'foreignKeys' => [
                ['childColumn' => 'manager_staff_id', 'parentTable' => 'staff', 'parentColumn' => 'staff_id'],
                ['childColumn' => 'address_id', 'parentTable' => 'address', 'parentColumn' => 'address_id'],
            ],
        ];
        $staff = [
            'primaryKey' => 'staff_id', 'primaryKeys' => ['staff_id'], 'rowEstimate' => 10, 'isView' => false,
            'columns' => [
                $this->column('staff_id', 'tinyint', false, 'auto_increment', 'PRI'),
                $this->column('first_name', 'varchar', false),
            ],
            'foreignKeys' => [],
        ];
        $address = [
            'primaryKey' => 'address_id', 'primaryKeys' => ['address_id'], 'rowEstimate' => 600, 'isView' => false,
            'columns' => [
                $this->column('address_id', 'smallint', false, 'auto_increment', 'PRI'),
                $this->column('address', 'varchar', false),
            ],
            'foreignKeys' => [],
        ];

        return $this->schemaStub(['customer' => $customer, 'store' => $store, 'staff' => $staff, 'address' => $address], 'customer');
    }

    /** @param array<string,array<string,mixed>> $tables */
    private function schemaStub(array $tables, string $root): DbSchema
    {
        return new class($tables, $root) extends DbSchema {
            public function __construct(private array $tables, private string $root) {}

            public function getSchemaInfo(?string $table = null): array
            {
                $relations = [];
                foreach ($this->tables[$this->root]['foreignKeys'] ?? [] as $fk) {
                    $relations[] = [
                        'childTable' => $this->root,
                        'childColumn' => $fk['childColumn'],
                        'parentTable' => $fk['parentTable'],
                        'parentColumn' => $fk['parentColumn'],
                    ];
                }
                return ['tables' => [$this->root => $this->tables[$this->root]], 'relations' => $relations];
            }

            public function getTableInfo(string $table): array
            {
                return $this->tables[$table] ?? [];
            }
        };
    }

    private function column(string $name, string $type, bool $nullable, string $extra = '', string $key = ''): array
    {
        return [
            'name' => $name,
            'type' => $type,
            'columnType' => $type,
            'nullable' => $nullable ? 'YES' : 'NO',
            'defaultValue' => null,
            'extra' => $extra,
            'maxLength' => str_contains($type, 'varchar') ? 128 : null,
            'columnKey' => $key,
        ];
    }
}
