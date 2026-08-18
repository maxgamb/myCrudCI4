<?php

declare(strict_types=1);

namespace Tests\MyCrud;

use App\Libraries\MyCrud\Core\RelationResolver;
use App\Libraries\MyCrud\Schema\DbSchema;
use Config\MyCrud;
use PHPUnit\Framework\TestCase;

final class RelationResolverManyToManyCreateTest extends TestCase
{
    public function testPurePivotTargetWithSelectableForeignKeyCanBeCreatedInline(): void
    {
        $resolver = new RelationResolver(
            $this->schema(languageRows: 6),
            new MyCrud()
        );

        $relations = $resolver->resolve('category');
        $manyToMany = array_values((array) ($relations['manyToMany'] ?? []));

        self::assertCount(1, $manyToMany);
        self::assertSame('film', $manyToMany[0]['relatedTable']);
        self::assertTrue($manyToMany[0]['relatedCreateSimple']);
        self::assertSame('', $manyToMany[0]['relatedCreateUnavailableReason']);

        $languageField = $manyToMany[0]['relatedCreate']['fields']['language_id'] ?? [];
        self::assertSame('select', $languageField['inputType'] ?? null);
        self::assertSame('language', $languageField['foreignKey']['parentTable'] ?? null);
        self::assertSame('select', $languageField['foreignKey']['optionMode'] ?? null);
    }

    public function testNestedForeignKeyStillBlocksWhenItRequiresAjaxHandling(): void
    {
        $resolver = new RelationResolver(
            $this->schema(languageRows: 6000),
            new MyCrud()
        );

        $relations = $resolver->resolve('category');
        $manyToMany = array_values((array) ($relations['manyToMany'] ?? []));

        self::assertCount(1, $manyToMany);
        self::assertFalse($manyToMany[0]['relatedCreateSimple']);
        self::assertSame('nested_foreign_key', $manyToMany[0]['relatedCreateUnavailableReason']);
    }

    private function schema(int $languageRows): DbSchema
    {
        $category = [
            'primaryKey' => 'category_id',
            'primaryKeys' => ['category_id'],
            'columns' => [
                $this->column('category_id', 'tinyint', nullable: false, extra: 'auto_increment'),
                $this->column('name', 'varchar', nullable: false, maxLength: 25),
                $this->managedTimestamp('last_update'),
            ],
            'foreignKeys' => [],
            'isView' => false,
        ];

        $pivot = [
            'primaryKey' => '',
            'primaryKeys' => ['film_id', 'category_id'],
            'columns' => [
                $this->column('film_id', 'smallint', nullable: false),
                $this->column('category_id', 'tinyint', nullable: false),
                $this->managedTimestamp('last_update'),
            ],
            'foreignKeys' => [
                [
                    'childColumn' => 'film_id',
                    'parentTable' => 'film',
                    'parentColumn' => 'film_id',
                ],
                [
                    'childColumn' => 'category_id',
                    'parentTable' => 'category',
                    'parentColumn' => 'category_id',
                ],
            ],
            'isView' => false,
        ];

        $film = [
            'primaryKey' => 'film_id',
            'primaryKeys' => ['film_id'],
            'columns' => [
                $this->column('film_id', 'smallint', nullable: false, extra: 'auto_increment'),
                $this->column('title', 'varchar', nullable: false, maxLength: 128),
                $this->column('language_id', 'tinyint', nullable: false),
                $this->column('original_language_id', 'tinyint', nullable: true),
                $this->managedTimestamp('last_update'),
            ],
            'foreignKeys' => [
                [
                    'childColumn' => 'language_id',
                    'parentTable' => 'language',
                    'parentColumn' => 'language_id',
                ],
                [
                    'childColumn' => 'original_language_id',
                    'parentTable' => 'language',
                    'parentColumn' => 'language_id',
                ],
            ],
            'isView' => false,
        ];

        $language = [
            'primaryKey' => 'language_id',
            'primaryKeys' => ['language_id'],
            'columns' => [
                $this->column('language_id', 'tinyint', nullable: false, extra: 'auto_increment'),
                $this->column('name', 'char', nullable: false, maxLength: 20),
                $this->managedTimestamp('last_update'),
            ],
            'foreignKeys' => [],
            'rowEstimate' => $languageRows,
            'isView' => false,
        ];

        return new class($category, $pivot, $film, $language) extends DbSchema {
            public function __construct(
                private array $category,
                private array $pivot,
                private array $film,
                private array $language
            ) {
            }

            public function getSchemaInfo(?string $table = null): array
            {
                return [
                    'tables' => [
                        'category' => $this->category,
                        'film_category' => $this->pivot,
                    ],
                    'relations' => [
                        [
                            'childTable' => 'film_category',
                            'childColumn' => 'category_id',
                            'parentTable' => 'category',
                            'parentColumn' => 'category_id',
                        ],
                    ],
                ];
            }

            public function getTableInfo(string $table): array
            {
                return match ($table) {
                    'category' => $this->category,
                    'film_category' => $this->pivot,
                    'film' => $this->film,
                    'language' => $this->language,
                    default => [],
                };
            }
        };
    }

    private function column(
        string $name,
        string $type,
        bool $nullable,
        string $extra = '',
        ?int $maxLength = null
    ): array {
        return [
            'name' => $name,
            'type' => $type,
            'columnType' => $type,
            'nullable' => $nullable ? 'YES' : 'NO',
            'defaultValue' => null,
            'extra' => $extra,
            'maxLength' => $maxLength,
            'columnKey' => str_contains($extra, 'auto_increment') ? 'PRI' : '',
        ];
    }

    private function managedTimestamp(string $name): array
    {
        return [
            'name' => $name,
            'type' => 'timestamp',
            'columnType' => 'timestamp',
            'nullable' => 'NO',
            'defaultValue' => 'CURRENT_TIMESTAMP',
            'extra' => 'DEFAULT_GENERATED on update CURRENT_TIMESTAMP',
            'maxLength' => null,
            'columnKey' => '',
        ];
    }
}
