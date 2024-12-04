<?php

namespace App\Models;

use App\Libraries\Debug;
use CodeIgniter\Model;

class ProcessosMovimentoModel extends Model
{
    protected $table            = 'processos_movimento';
    protected $primaryKey       = 'id_movimento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'id_movimento',
        'processo_id',
        'comunicacao_id',
        'data_disponibilizacao',
        'tipoComunicacao',
        'texto',
        'meio',
        'link',
        'datadisponibilizacao',
        'dataenvio',
        'meiocompleto',

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


    private $debug;

    public function __construct()
    {
        $this->debug = new Debug();
    }



    public function salvarMovimento($intimacao){


    $movimento = [
        'processo_id'               => $intimacao['processo_id'],
        'comunicacao_id'            => $intimacao['id_intimacao'],
        'data_disponibilizacao'     => $intimacao['data_disponibilizacao'],
        'tipoComunicacao'           => $intimacao['tipoComunicacao'],
        'texto'                     => $intimacao['texto'],
        'meio'                      => $intimacao['meio'],
        'link'                      => $intimacao['link'],
        'datadisponibilizacao'      => $intimacao['datadisponibilizacao'],
        'dataenvio'                 => $intimacao['dataenvio'],
        'meiocompleto'              => $intimacao['meiocompleto'],
    ];

    $this->debug->debug($movimento);
    //$this->insert($movimento);




}





}
