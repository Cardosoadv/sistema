<?php

namespace App\Models;

use App\Libraries\Debug;
use CodeIgniter\Model;

class ProcessosPartesModel extends Model
{
    protected $table            = 'processos_partes';
    protected $primaryKey       = 'id_parte';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [

        'id_parte', 'pessoa_id', 'qualificacao', 'processo_id', 'e_cliente'
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

    public function salvarParte($parte, $idProcesso){
        $parteMovimento = [
            'processo_id'           => $idProcesso,
            'nome'                  => $parte['nome'],
        ];

        $this->debug->debug($parteMovimento);
        //$this->insert($parteMovimento);
    }








}
