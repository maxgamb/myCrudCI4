<?php

use App\Libraries\Crud\RelationalCreateProcessor;

$config = [
    'conti__preno_id' => [
        'enabled' => true,
        'childTable' => 'conti',
        'foreignKey' => 'preno_id',
        'primaryKey' => 'conto_id',
        'title' => 'Conti',
        'create' => [
            'enabled' => true,
            'mode' => 'inline',
            'minRows' => 0,
            'maxRows' => 2,
            'fields' => [
                'conto_id' => ['primary' => true, 'autoIncrement' => true],
                'preno_id' => ['writable' => false],
                'descrizione' => ['validationRules' => 'required|max_length[100]'],
                'importo' => ['validationRules' => 'permit_empty|decimal'],
                'updated_at' => ['databaseManaged' => true],
            ],
        ],
    ],
];

$post = [
    'relations' => [
        'conti__preno_id' => [
            [
                'conto_id' => 999,
                'preno_id' => 777,
                'descrizione' => 'Camera',
                'importo' => '450.00',
                'updated_at' => '2000-01-01 00:00:00',
            ],
        ],
    ],
];

$result = (new RelationalCreateProcessor())->prepare($post, $config);
$row = $result['relations']['conti__preno_id'][0] ?? [];

assert(!array_key_exists('conto_id', $row));
assert(!array_key_exists('preno_id', $row));
assert(!array_key_exists('updated_at', $row));
assert(($row['descrizione'] ?? null) === 'Camera');
