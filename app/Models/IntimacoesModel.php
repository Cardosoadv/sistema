<?php

namespace App\Models;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

/**
 * Model para CRUD dos processos no Banco de Dados
 */
class IntimacoesModel extends Model
{
    protected $table            = 'intimacoes';
    protected $primaryKey       = 'id_intimacao';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
            'id_intimacao',
            'data_disponibilizacao',
            'siglaTribunal',
            'tipoComunicacao',
            'nomeOrgao',
            'texto',
            'numero_processo',
            'meio',
            'link',
            'tipoDocumento',
            'codigoClasse',
            'numeroComunicacao',
            'ativo',
            'hash',
            'status',
            'motivo_cancelamento',
            'data_cancelamento',
            'datadisponibilizacao',
            'dataenvio',
            'meiocompleto',
            'numeroprocessocommascara',
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
}
