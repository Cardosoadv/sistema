<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table            = 'pessoas';
    protected $primaryKey       = 'id_pessoa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pessoa','nome', 'email', 'celular', 'cpf_cnpj',
        'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'cep',
        'aquisicao_dt'
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
    protected $afterInsert    = ['setTipoPessoa'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function setTipoPessoa(array $data){
        $pessoa['pessoa_id'] = $data['id'];
        $pessoa['tipo_pessoa'] = "Cliente";
        $this->db->table('tipo_pessoa')->insert($pessoa);
    }
}
