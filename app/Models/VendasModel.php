<?php

namespace App\Models;

use CodeIgniter\Model;

class VendasModel extends Model
{
    protected $table            = 'vendas';
    protected $primaryKey       = 'id_venda';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'venda',
        'vencimento_dt',
        'valor',
        'categoria',
        'fornecedor',
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

    public function getOpenRevenues(){
        $db = db_connect();
		$builder = $db->table('revenues v');
		$builder->join('receipts_revenues r', 'v.id=r.revenues_id', 'left');
		$query = $builder;
		return $query->get();
    }



}
