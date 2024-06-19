<?php

namespace App\Models;

use CodeIgniter\Model;

class ProcessosModel extends Model
{
    protected $table            = 'processos';
    protected $primaryKey       = 'id_processo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_processo', 'nome', 'acao', 'numero', 'juizo', 'vlr_causa', 'dt_distribuicao', 'vlr_condenacao'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Metodo para adicionar parte ao Processo
     */
    public function adicionarPartes(array $parte){
        $this->db->table('processos_partes')->insert($parte);
    }

    /**
     * Metodo para listar partes do Processo
     */
    public function getPartes(int $processo_id){
        $this->db->table('processos_partes')->where('processo_id', $processo_id);
    }


}
