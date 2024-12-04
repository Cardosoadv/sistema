<?php

namespace App\Models;

use App\Libraries\Debug;
use CodeIgniter\Model;

class ProcessosAdvogadosModel extends Model
{
    protected $table            = 'processos_advogados';
    protected $primaryKey       = 'id_pk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'processo_id',
        'advogado_id',    
        'advogado_nome',
        'advogado_oab',
        'advogado_oab_uf',
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

    public function salvarAdvogados($advogado, $idProcesso){

        $advogadoMovimento  =[
            'processo_id'           => $idProcesso,
            'advogado_id'           => $advogado['advogado_id'],
            'advogado_nome'         => $advogado['advogado_nome'],
            'advogado_oab'          => $advogado['advogado_oab'],
            'advogado_oab_uf'       => $advogado['advogado_oab_uf'],
        ];

        //$this->insert($advogadoMovimento);

        $this->debug->debug($advogadoMovimento);

    }





}
