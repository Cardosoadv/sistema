<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProcessosModel;
use CodeIgniter\HTTP\ResponseInterface;

class Processos extends BaseController
{
    
    private array $processos = [
        'id_processo', 'nome', 'acao', 'numero', 'juizo', 'vlr_causa', 'dt_distribuicao', 'vlr_condenacao'
    ];
    
    public function index()
    {
        $data = $this->img();
        $ProcessosModel = new ProcessosModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['processos'] = $ProcessosModel
            ->findAll();
        } else {
            $data['processos'] = $ProcessosModel
            ->like('nome',$s | 'acao', $s)
            ->findAll();
        }
        return  view('processo/processos', $data);
    }

       /**
     * Metodo para exibir o formulário de inserção de processo
     */
    public function novo(){
        $data = $this->img();
        return  view('processo/novoProcesso', $data);
    }




    
}
