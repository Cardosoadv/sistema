<?php

namespace App\Models;

use CodeIgniter\Model;

class DespesasModel extends Model
{
    protected $table            = 'despesas';
    protected $primaryKey       = 'id_despesa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'despesa',
        'vencimento_dt',
        'valor',
        'categoria',
        'conciliado',
        'pessoa_id',
        'comentario',
        'rateio',
        ];

    // Dates
    protected $useTimestamps = true;
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
     * Retorna as despesas vencidas
     * @param string $s para pesquisar despesas por nome
     * @return array
     */
    public function despesasVencidas($s='%'){
        $query = $this->db->table('despesas as d')
        ->select('d.id_despesa, d.despesa, d.vencimento_dt')
        ->like('d.despesa', $s)
        ->join('despesas_pagamentos as dp', 'dp.despesa_id = d.id_despesa', 'left')
        ->where('vencimento_dt <', date('Y-m-d'))
        ->where('dp.pagamento_dt IS NULL')
        ->get();
        return $query->getResultArray();
    }



}
