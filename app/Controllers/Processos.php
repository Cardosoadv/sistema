<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnotacaoProcessosModel;
use App\Models\ProcessosModel;


class Processos extends BaseController
{
    
    private array $processos = [
        'id_processo', 'nome', 'acao', 'numero', 'juizo', 'vlr_causa', 'dt_distribuicao', 'vlr_condenacao'
    ];

    private function getAnotacao($id){
        $AnotacaoProcessosModel = new AnotacaoProcessosModel();
        $data['anotacoes'] = $AnotacaoProcessosModel->where('processo_id', $id)->findAll();
        return $data;
    }
    
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

    public function adicionar(){
        $this->processos = [
            'nome'                  =>$this->request->getPost('nome'), 
            'acao'                  =>$this->request->getPost('acao'), 
            'numero'                =>$this->request->getPost('numero'), 
            'juizo'                 =>$this->request->getPost('juizo'), 
            'vlr_causa'             =>$this->request->getPost('vlr_causa'), 
            'dt_distribuicao'       =>$this->request->getPost('dt_distribuicao'), 
            'vlr_condenacao'        =>$this->request->getPost('vlr_condenacao'),
        ];
        $ProcessosModel = new ProcessosModel();
        $ProcessosModel->insert($this->processos);
        
        //Adicionar Partes
        $clientePrincipal = $this->request->getPost('cliente_principal');
        $cliente = [
            'pessoa_id' => $clientePrincipal,
            'processo_id' => $ProcessosModel->getInsertID(),
            'qualificacao' => $this->request->getPost('cliente_qualificacao'),
            'e_cliente' => '1',
        ];
        $ProcessosModel->adicionarPartes($cliente);
        $outraParte = $this->request->getPost('outra_parte');
        $contraParte = [
            'pessoa_id'         => $outraParte,
            'processo_id'       => $ProcessosModel->getInsertID(),
            'qualificacao'      => $this->request->getPost('outraParte_qualificacao'),
            'e_cliente'         => '0',
        ];
        $ProcessosModel->adicionarPartes($contraParte);

        //Mensagem de Sucesso
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);

        //Redirecionar para a página de Processos
        return $this->response->redirect(site_url('processos')); 
    }

    public function consultar($id)
    {
        $data = $this->img();
        $ProcessosModels = new ProcessosModel();
        $data['processo'] = $ProcessosModels->find($id);
        $data['anotacoes'] = $this->getAnotacao($id);
        return  view('processo/consultarProcesso', $data);
    }

    /**
     * Metodo para deletar um cliente
     */
    public function delete($id)
    {
        $ProcessosModels = new ProcessosModel();
        $ProcessosModels->delete($id);
        return redirect()->to(previous_url());
    }

    /**
     * Metodo para adicionar uma anotação ao processo
     */
    public function adicionarAnotacao($id)
    {
        $data = [
            'processo_id' => $id,
            'titulo' => $this->request->getPost('titulo'),
            'anotacao' => $this->request->getPost('anotacao'),
            'privacidade' => $this->request->getPost('privacidade')
        ];
        $anotacaoProcessosModels = new AnotacaoProcessosModel();
        $anotacaoProcessosModels->insert($data);
        return redirect()->to(previous_url());
    }


}
