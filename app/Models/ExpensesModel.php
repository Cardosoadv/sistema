<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpensesModel extends Model
{
    protected $table            = 'expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'expenses', 'due_dt', 'value', 'category', 'client_id',
        'late_fee', 'interest', 'charges',
        'user1', 'user2', 'user3', 'user4', 'user5', 'user6', 'share_user1', 'share_user2', 'share_user3', 'share_user4', 'share_user5', 'share_user6', 'reconciled', 'comments'
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

    public function getOpenExpenses(){
        $db = db_connect();
		$builder = $db->table('expenses c');
		$builder->join('payments_expenses p', 'c.id=p.expenses_id', 'left');
		$query = $builder;
		return $query->get();
    }



}
