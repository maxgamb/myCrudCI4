<?php

namespace App\Models;

use App\Entities\CamereEntity;
use CodeIgniter\Model;
use InvalidArgumentException;

class CamereModel extends Model
{
    protected $table = 'camere';
    protected $primaryKey = 'camera_id';
    protected $returnType = \App\Entities\CamereEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
);
    protected $useTimestamps = false;
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    public function getList(array $filters = []): array
    {
        $builder = $this->builder();
        $builder->select([
            'camere.*',
            'tipologia_camera.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);

        $builder->join('tipologia_camera', 'tipologia_camera.tipologia_id = camere.tipologia_id', 'left');

        foreach ($filters as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (in_array($field, $this->allowedFields, true) || $field === $this->primaryKey) {
                $builder->where("camere." . $field, $value);
            }
        }

        return $builder
            ->orderBy("camere.camera_id", 'DESC')
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
            'camere.*',
            'tipologia_camera.nome_tipologia AS tipologia_camera_nome_tipologia'
        ]);

        $builder->join('tipologia_camera', 'tipologia_camera.tipologia_id = camere.tipologia_id', 'left');

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
