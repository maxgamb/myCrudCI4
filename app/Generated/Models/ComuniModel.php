<?php

namespace App\Models;

use App\Entities\ComuniEntity;
use CodeIgniter\Model;
use InvalidArgumentException;

class ComuniModel extends Model
{
    protected $table = 'comuni';
    protected $primaryKey = 'Comuni_Codice';
    protected $returnType = \App\Entities\ComuniEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'Comuni_Codice',
  1 => 'Comuni_Nome',
  2 => 'Comuni_Prov',
  3 => 'Comuni_CAP',
  4 => 'Comuni_Prefisso',
  5 => 'Comuni_ColExcel',
  6 => 'Comuni_Nazione',
  7 => 'Comuni_Lingua',
  8 => 'nazione_iso2',
  9 => 'nazione_iso3',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    public function getList(array $filters = []): array
    {
        $builder = $this->builder();
        $builder->select([
            'comuni.*'
        ]);


        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (in_array($field, $this->allowedFields, true) || $field === $this->primaryKey) {
                $builder->where("comuni." . $field, $value);
            }
        }

        return $builder
            ->orderBy("comuni.Comuni_Codice", 'DESC')
            ->get()
            ->getResult();
    }

    public function getDetail(int|string $id): ?object
    {
        return $this->builder()
            ->where($this->primaryKey, $id)
            ->get()
            ->getRow($this->returnType);
    }

    public function datatableBuilder(): \CodeIgniter\Database\BaseBuilder
    {
        $builder = $this->builder();
        $builder->select([
            'comuni.*'
        ]);


        return $builder;
    }

    public function getRelatedChildren(
        string $childTable,
        string $foreignKey,
        int|string $parentId,
        string $orderField,
        int $limit = 20
    ): array {
        $this->assertIdentifier($childTable);
        $this->assertIdentifier($foreignKey);
        $this->assertIdentifier($orderField);

        return $this->db
            ->table($childTable)
            ->where($foreignKey, $parentId)
            ->orderBy($orderField, 'DESC')
            ->limit(max(1, min(200, $limit)))
            ->get()
            ->getResult();
    }

    public function countRelatedChildren(
        string $childTable,
        string $foreignKey,
        int|string $parentId
    ): int {
        $this->assertIdentifier($childTable);
        $this->assertIdentifier($foreignKey);

        return $this->db
            ->table($childTable)
            ->where($foreignKey, $parentId)
            ->countAllResults();
    }

    private function assertIdentifier(string $identifier): void
    {
        if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $identifier) !== 1) {
            throw new InvalidArgumentException('Identificatore database non valido.');
        }
    }
}
