<?php

namespace App\Models;

use App\Libraries\Debug;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Model;

/**
 * Model para CRUD dos processos no Banco de Dados
 */
class ProcessosModel extends Model
{
    protected $table            = 'processos';
    protected $primaryKey       = 'id_processo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_processo', 'processo', 'acao', 'numero', 'juizo', 
        'vlr_causa', 'dt_distribuicao', 'vlr_condenacao', 'comentarios',
        'siglaTribunal', 'nomeOrgao', 'numero_processo', 'tipoDocumento',
        'codigoClasse', 'ativo', 'numeroprocessocommascara',   
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

    private $debug;

    public function __construct()
    {
        $this->debug = new Debug();
    }

    /**
     * Metodo para realizar o join das tabelas de processos e pessoas
     */
    public function joinClientes()
    {
        $query = $this->db->table('processos as p')
        ->select('p.id_processo, p.processo, p.numero, c.nome')
        ->where('p.deleted_at', null)
        ->join('processos_partes as pp', 'p.id_processo = pp.processo_id', 'left')
            ->where('pp.deleted_at', null)
            ->where('pp.e_cliente=1')
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

    /**
     * Metódo para receber o cliente vinculado ao processo
     */
    public function getCliente($processo_id){
        $query = $this->db->table('processos_partes')
        ->where('processo_id', $processo_id)
        ->where('e_cliente', 1)
        ->get();
        return $query->getResultArray();
    }

    /**
     * Metódo para receber a outra parte vinculada ao processo
     */
    public function getOutraParte($processo_id){
        $query = $this->db->table('processos_partes')
        ->where('processo_id', $processo_id)
        ->where('e_cliente', 0)
        ->get();
        return $query->getResultArray();
    }

        /**
     * Função para verificar se a intimação já consta do db
     * @param string $id
     * @return bool
     */
    public function exitingProcesso(string $numeroProcesso): bool {
        $query = $this->db->table('processos')
                          ->select('numero_processo')
                          ->where('numero_processo', $numeroProcesso)
                          ->get();
        return $query->getRowArray() !== null;
    }

    public function salvarProcesso($intimacao){
        
        $processo = [
            'siglaTribunal'                     => $intimacao['siglaTribunal'],
            'nomeOrgao'                         => $intimacao['nomeOrgao'],
            'numero_processo'                   => $intimacao['numero_processo'],
            'tipoDocumento'                     => $intimacao['tipoDocumento'],
            'codigoClasse'                      => $intimacao['codigoClasse'],
            'ativo'                             => $intimacao['ativo'],
            'numeroprocessocommascara'          => $intimacao['numeroprocessocommascara'],
        ];

        $this->debug->debug($processo);
        //$this->processosModel->insert($processo);


    }




}
