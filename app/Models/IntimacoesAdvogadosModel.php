<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

/**
 * Model para CRUD dos advogados das Intimações no Banco de Dados
 */

class IntimacoesAdvogadosModel extends Model
{
    protected $table            = 'intimacoes_advogados';
    protected $primaryKey       = 'id_pk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'comunicacao_id',
        'advogado_id',    
        'advogado_nome',
        'advogado_oab',
        'advogado_oab_uf',
        'created_at',
        'updated_at',
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
     * Função salvar os advogados vinculados às intimações
     * @param array $itemsAdvogados
     */
    public function salvarAdvogados($itemsAdvogados){

        $advogados = [

            'id'                => $itemsAdvogados['id'],
            'comunicacao_id'    => $itemsAdvogados['comunicacao_id'],
            'advogado_id'       => $itemsAdvogados['advogado_id'],    
            'created_at'        => $itemsAdvogados['created_at'],
            'updated_at'        => $itemsAdvogados['updated_at'],
            'advogado_nome'     => $itemsAdvogados['advogado']['nome'],
            'advogado_oab'      => $itemsAdvogados['advogado']['numero_oab'],
            'advogado_oab_uf'   => $itemsAdvogados['advogado']['uf_oab'],
        ];
        $this->insert($advogados);
    }
}
