<?php

namespace App\Models;

use App\Entities\AppIpEntity;
use CodeIgniter\Model;
use InvalidArgumentException;

class AppIpModel extends Model
{
    protected $table = 'app_ip';
    protected $primaryKey = 'app_ip_id';
    protected $returnType = \App\Entities\AppIpEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'ip_aderss',
  1 => 'Livello',
  2 => 'data',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    public function getList(array $filters = []): array
    {
        $builder = $this->builder();
        $builder->select([
            'app_ip.*'
        ]);


        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (in_array($field, $this->allowedFields, true) || $field === $this->primaryKey) {
                $builder->where("app_ip." . $field, $value);
            }
        }

        return $builder
            ->orderBy("app_ip.app_ip_id", 'DESC')
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
            'app_ip.*'
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
