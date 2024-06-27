<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnotacaoProcessosModel;
use App\Models\ProcessosModel;


class Processos extends BaseController
{
    /**
     * Define o objeto processos
     */
    private array $processos = [
        'id_processo', 'processo', 'acao', 'numero', 'juizo', 'vlr_causa', 'dt_distribuicao', 'vlr_condenacao'
    ];

    /**
     * Metodo para reeber anotações dos Processos
     */
    private function getAnotacao($id){
        $AnotacaoProcessosModel = new AnotacaoProcessosModel();
        $data['anotacoes'] = $AnotacaoProcessosModel->where('processo_id', $id)->findAll();
        return $data;
    }
    
    /**
     * Pesquisa para exibir a lista de Processos
     */
    public function index()
    {
        $data = $this->img();
        $ProcessosModel = new ProcessosModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['processos'] = $ProcessosModel
            ->joinClientes();
        } else {
            $data['processos'] = $ProcessosModel
            ->like('nome',$s | 'acao', $s)
            ->joinClientes();
        }
        return  view('processo/processos', $data);
    }

       /**
     * Metodo para exibir o formulário de inserção de processo
     */
    public function novo(){
        $data = $this->img();
        $combo = new Combos();
        $dataArrayCombo = $combo->ArrayComboPessoas([['nome'=>'cliente_principal','selected'=>''],['nome'=>'outra_parte','selected'=>'']]);
        $data['cliente_principal'] = $dataArrayCombo[0];
        $data['outra_parte'] = $dataArrayCombo[1];
        
        return  view('processo/novoProcesso', $data);
    }

    /**
     * Metodo para salvar Processos no Banco de Dados
     */
    public function adicionar(){
        $this->processos = [
            'processo'              =>$this->request->getPost('processo'), 
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

    /**
     * Metodo para exibir tela de Consulta 
     */
    public function consultar($id)
    {
        $data = $this->img();
        $ProcessosModels = new ProcessosModel();
        $data['processo'] = $ProcessosModels->find($id);
        $data['anotacoes'] = $this->getAnotacao($id);
        $cliente = $ProcessosModels->getCliente($id);
        $outraParte = $ProcessosModels->getOutraParte($id);
        $combo = new Combos();
        $dataArrayCombo = $combo->ArrayComboPessoas([['nome'=>'cliente_principal','selected'=>$cliente[0]['pessoa_id']],['nome'=>'outra_parte','selected'=>$outraParte[0]['pessoa_id']]]);
        $data['cliente_principal'] = $dataArrayCombo[0];
        $data['outra_parte'] = $dataArrayCombo[1];
        $data['clientes'] = $ProcessosModels->getCliente($id);
        $data['outrasPessoas'] = $ProcessosModels->getOutraParte($id);
        return  view('processo/consultarProcesso', $data);
    }

    public function testar()
    {
        $ProcessosModels = new ProcessosModel();
        $data['cliente'] = $ProcessosModels->getCliente(5);
        $data['outraParte'] = $ProcessosModels->getOutraParte(5);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function atualizar($id){
        $processo_id = $id;
        $this->processos = [
            'processo'              =>$this->request->getPost('processo'), 
            'acao'                  =>$this->request->getPost('acao'), 
            'numero'                =>$this->request->getPost('numero'), 
            'juizo'                 =>$this->request->getPost('juizo'), 
            'vlr_causa'             =>$this->request->getPost('vlr_causa'), 
            'dt_distribuicao'       =>$this->request->getPost('dt_distribuicao'), 
            'vlr_condenacao'        =>$this->request->getPost('vlr_condenacao'),
        ];
        $ProcessosModel = new ProcessosModel();
        $ProcessosModel->update($processo_id, $this->processos);
        
        //Atualizar Partes
        $id_cliente = $this->request->getPost('id_cliente');
        $cliente = [

            'pessoa_id' => $this->request->getPost('cliente_principal'),
            'qualificacao' => $this->request->getPost('cliente_qualificacao'),
            'e_cliente' => '1',
        ];
        $ProcessosModel->atualizarPartes($cliente, $id_cliente);

        $id_outraParte = $this->request->getPost('id_outraParte');
        $contraParte = [
            'pessoa_id'         => $this->request->getPost('outra_parte'),
            'qualificacao'      => $this->request->getPost('outraParte_qualificacao'),
            'e_cliente'         => '0',
        ];
        $ProcessosModel->atualizarPartes($contraParte, $id_outraParte);

        //Mensagem de Sucesso
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);

        //Redirecionar para a página de Processos
        return $this->response->redirect(site_url('processos')); 
    }

    /**
     * Metodo para deletar um cliente
     */
    public function delete($id)
    {
        $ProcessosModels = new ProcessosModel();
        $ProcessosModels->delete($id);
        return $this->response->redirect(site_url('processos'));
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
