<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

class ProcessosModel extends Model
{
    protected $table            = 'processos';
    protected $primaryKey       = 'id_processo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
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

    public function joinClientes()
    {
        $query = $this->db->table('processos as p')
        ->where('p.deleted_at', null)
        ->join('processos_partes as pp', 'p.id_processo = pp.processo_id', 'left')
            ->where('pp.deleted_at', null)
            ->join('pessoas as c', 'pp.pessoa_id = c.id_pessoa')
            ->where('c.deleted_at', null)
            ->get();
            return $query->getResultArray();
    }
    
    /**
     * Metodo para adicionar parte ao Processo
     */
    public function adicionarPartes(array $parte){
        $this->db->table('processos_partes')->insert($parte);
    }

        /**
     * Metodo para atualizar parte do Processo
     * @param $parte array de dados da parte
     * @param $id_parte id da parte a ser atualizada 
     */
    public function atualizarPartes(array $parte, $id_parte){
        $builder = $this->db->table('processos_partes');
        $data = $parte;
        $data['updated_at'] = new RawSql('CURRENT_TIMESTAMP()');
        $builder->where('id_parte', $id_parte);
        $builder->update($data);
    }

    public function getCliente($processo_id){
        $query = $this->db->table('processos_partes')
        ->where('processo_id', $processo_id)
        ->where('e_cliente', 1)
        ->get();
        return $query->getResultArray();
    }

    public function getOutraParte($processo_id){
        $query = $this->db->table('processos_partes')
        ->where('processo_id', $processo_id)
        ->where('e_cliente', 0)
        ->get();
        return $query->getResultArray();
    }



}
