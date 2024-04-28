<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use DateTime;

class Clientes extends BaseController
{
    private array $cliente = [
        'nome', 'email', 'celular', 'cpf_cnpj',
        'logradouro', 'numero','complemento', 'bairro', 'cidade', 'estado', 'cep',
        'aquisicao_dt'
    ]; 
  
    
    //função para formatar a data. Ainda não foi testada.
    protected function novaData($data)
    {
    $novaData = date_format(new DateTime($data), 'Y-m-d');
    return $novaData;
    }
 
    public function index()
    {
        $data = $this->img();
        $ClientesModel = new ClientesModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['clientes'] = $ClientesModel
            ->findAll();
        } else {
            $data['clientes'] = $ClientesModel
            ->like('nome',$s)
            ->findAll();
        }
        return  view('cliente/clientes', $data);
    }
    /**
     * Metodo para exibir o formulário de inserção de cliente
     */
    public function novo(){
        $data = $this->img();
        return  view('cliente/novoCliente', $data);
    }

    /**
     * Metódo para salvar os dados do novo cliente no Banco de Dados
     * 
     */
    public function adicionar()
    {
        $ClientesModel = new ClientesModel();
        $this->cliente = [
            'nome'            =>$this->request->getPost('nome'),
            'email'           =>$this->request->getPost('email'),
            'celular'         =>$this->request->getPost('celular'),
            'cpf_cnpj'        =>$this->request->getPost('cpf_cnpj'),
            'logradouro'      =>$this->request->getPost('logradouro'),
            'numero'          =>$this->request->getPost('numero'),
            'complemento'     =>$this->request->getPost('complemento'),
            'bairro'          =>$this->request->getPost('bairro'),
            'cidade'          =>$this->request->getPost('cidade'),
            'estado'          =>$this->request->getPost('estado'),
            'cep'             =>$this->request->getPost('cep'),
            'aquisicao_dt'    =>$this->request->getPost('aquisicao_dt'),
        ];
        
        $ClientesModel->insert($this->cliente);
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('clientes'));
    }

    /**
     * Metodo para deletar um cliente
     */
    public function delete($id)
    {
        $ClientesModel = new ClientesModel();
        $ClientesModel->delete($id);
        return redirect()->to(previous_url());
    }

    /**
     * Metodo para Consultar Cliente
     */
    public function consultar($id)
    {
        $data = $this->img();
        $ClientesModel = new ClientesModel();
        $data['cliente'] = $ClientesModel->find($id);
        return  view('cliente/consultarCliente', $data);
    }
    /**
     * Metódo para salvar os dados do novo cliente no Banco de Dados
     * 
     */
    public function atualizar($id)
    {
        $ClientesModel = new ClientesModel();
        $this->cliente = [
            'nome'            =>$this->request->getPost('nome'),
            'email'           =>$this->request->getPost('email'),
            'celular'         =>$this->request->getPost('celular'),
            'cpf_cnpj'        =>$this->request->getPost('cpf_cnpj'),
            'logradouro'      =>$this->request->getPost('logradouro'),
            'numero'          =>$this->request->getPost('numero'),
            'complemento'     =>$this->request->getPost('complemento'),
            'bairro'          =>$this->request->getPost('bairro'),
            'cidade'          =>$this->request->getPost('cidade'),
            'estado'          =>$this->request->getPost('estado'),
            'cep'             =>$this->request->getPost('cep'),
            'aquisicao_dt'    =>$this->request->getPost('aquisicao_dt'),
        ];
        
        $ClientesModel->update($id,$this->cliente);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('clientes'));
    }








    public function get_client($id)
    {
        $ClientsModel = new ClientsModel();
        $data = $ClientsModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }


}
