<?php

namespace App\Models;
use CodeIgniter\Model;

/**
 * Model para CRUD dos processos no Banco de Dados
 */
class IntimacoesModel extends Model
{
    protected $table            = 'intimacoes';
    protected $primaryKey       = 'id_intimacao';
    protected $useAutoIncrement = false;
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

    public function exitingIntimacao(string $id){
        $existingIntimacao = $this->db->table('intimacoes')
        ->where('id_intimacao', $id)
        ->get()
        ->getResultArray();
        return isset($existingIntimacao['id_intimacao']);
        //return $existingIntimacao;
    }

    public function bindingIntimacoes($items){
        $intimacao = [
            'id_intimacao'              => $items['id'],
            'data_disponibilizacao'     => $items['data_disponibilizacao'],
            'siglaTribunal'             => $items['siglaTribunal'],
            'tipoComunicacao'           => $items['tipoComunicacao'],
            'nomeOrgao'                 => $items['nomeOrgao'],
            'texto'                     => $items['texto'],
            'numero_processo'           => $items['numero_processo'],
            'meio'                      => $items['meio'],
            'link'                      => $items['link'],
            'tipoDocumento'             => $items['tipoDocumento'],
            'codigoClasse'              => $items['codigoClasse'],
            'numeroComunicacao'         => $items['numeroComunicacao'],
            'ativo'                     => ($items['ativo'])?1:0,
            'hash'                      => $items['hash'],
            'status'                    => $items['status'],
            'motivo_cancelamento'       => $items['motivo_cancelamento'],
            'data_cancelamento'         => $items['data_cancelamento'],
            'datadisponibilizacao'      => $items['datadisponibilizacao'],
            'dataenvio'                 => $items['dataenvio'],
            'meiocompleto'              => $items['meiocompleto'],
            'numeroprocessocommascara'  => $items['numeroprocessocommascara'],
        ];
    }
    








}
