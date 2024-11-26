<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

/**
 * Model para CRUD dos destinatários das intimações no Banco de Dados
 */

class IntimacoesDestinatariosModel extends Model
{
    protected $table            = 'intimacoes_destinatario';
    protected $primaryKey       = 'id_pk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'polo',
        'comunicacao_id',
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
     * Função salvar os destinatários vinculados às intimações
     * @param array $itemsDestinatario
     */
    public function salvarDestinatarios($itemsDestinatario){
    $destinatarios = [
        'comunicacao_id' => $itemsDestinatario['comunicacao_id'],
        'nome'           => $itemsDestinatario['nome'],
        'polo'           => $itemsDestinatario['polo'],
    ];
    $this->insert($destinatarios);
    //$this->debug($destinatarios);
    }

    private function debug($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}