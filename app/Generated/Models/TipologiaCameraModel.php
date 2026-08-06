<?php

namespace App\Models;

use App\Entities\TipologiaCameraEntity;
use CodeIgniter\Model;
use InvalidArgumentException;

class TipologiaCameraModel extends Model
{
    protected $table = 'tipologia_camera';
    protected $primaryKey = 'tipologia_id';
    protected $returnType = \App\Entities\TipologiaCameraEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'nome_tipologia',
  1 => 'nome_tipologia_en',
  2 => 'nome_tipologia_fr',
  3 => 'nome_tipologia_de',
  4 => 'nome_tipologia_sp',
  5 => 'nome_tipologia_jp',
  6 => 'tipologia_sigla',
  7 => 'numero_pax',
  8 => 'tipologia_camera_data_record',
  9 => 'tipologia_camera_utente_id',
  10 => 'perc_prezzo',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    public function getList(array $filters = []): array
    {
        $builder = $this->builder();
        $builder->select([
            'tipologia_camera.*'
        ]);


        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (in_array($field, $this->allowedFields, true) || $field === $this->primaryKey) {
                $builder->where("tipologia_camera." . $field, $value);
            }
        }

        return $builder
            ->orderBy("tipologia_camera.tipologia_id", 'DESC')
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
            'tipologia_camera.*'
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
