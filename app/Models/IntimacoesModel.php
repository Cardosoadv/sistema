<?php

namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\ConverterData;





/**
 * Model para CRUD das intimações dos processos no Banco de Dados
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

    


    /**
     * Função para verificar se a intimação já consta do db
     * @param string $id
     * @return bool
     */
    public function exitingIntimacao(string $id): bool {
        $query = $this->db->table('intimacoes')
                          ->select('id_intimacao')
                          ->where('id_intimacao', $id)
                          ->get();
        return $query->getRowArray() !== null;
    }

    /**
     * Função salvar as intimações no db
     * @param array $items
     */
    public function salvarIntimacoes($items){

        $converter = new ConverterData();

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
            'datadisponibilizacao'      => $converter->novaData($items['datadisponibilizacao']),
            'dataenvio'                 => $converter->novaData($items['dataenvio']),
            'meiocompleto'              => $items['meiocompleto'],
            'numeroprocessocommascara'  => $items['numeroprocessocommascara'],
        ];
        $this->insert($intimacao);
        //$this->debug($intimacao);
    }

    private function getAdvogados($id_intimacao){

        $builder = $this->db->table('intimacoes_advogados')
        ->where('comunicacao_id', $id_intimacao)
        ->get()
        ->getResultArray();
        return $builder;
    }

    private function getDestinatarios($id_intimacao){

        $intimacao = $this->db->table('intimacoes_destinatario')
        ->where('comunicacao_id', $id_intimacao)
        ->get()
        ->getResultArray();
        return $intimacao;
    }

    /**
    * Função para agrupar dados de todas as tabelas de intimação
    */
    public function getIntimacoesNaoTratadas(){
        $intimacoes = $this->db->table('intimacoes')
        ->where('statusTratamento',0)
        ->get()
        ->getResultArray();
        $data = [];
        foreach($intimacoes as $intimacao){
            $intimacaoAgrupada = $intimacao;
            $intimacaoAgrupada['advogados'] = $this->getAdvogados($intimacao['id_intimacao']);
            $intimacaoAgrupada['destinatarios'] = $this->getDestinatarios($intimacao['id_intimacao']);    
            array_push($data, $intimacaoAgrupada);    
        }
        return $data;
    }

    
    private function debug($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}
