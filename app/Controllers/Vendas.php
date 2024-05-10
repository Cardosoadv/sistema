<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VendasModel;
use DateTime;

class Vendas extends BaseController
{   
    private array $venda = [
        'venda',
        'vencimento_dt',
        'valor',
        'categoria',
        'fornecedor',
        'comentario',
        'rateio',
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
        $VendasModels = new VendasModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['vendas'] = $VendasModels
            ->findAll();
        } else {
            $data['vendas'] = $VendasModels
            ->like('venda',$s)
            ->findAll();
        }
        return  view('venda/vendas', $data);
    }
    /**
     * Metodo para exibir o formulário de inserção de cliente
     */
    public function novo(){
        $data = $this->img();
        return  view('venda/novaVenda', $data);
    }

    /**
     * Metódo para salvar os dados do novo cliente no Banco de Dados
     * 
     */
    public function adicionar()
    {
        $this->venda = [
        'venda'             =>$this->request->getPost('venda'),
        'vencimento_dt'     =>$this->request->getPost('vencimento_dt'),
        'valor'             =>$this->request->getPost('valor'),
        'categoria'         =>$this->request->getPost('categoria'),
        'conciliado'        =>$this->request->getPost('conciliado'),
        'cliente'           =>$this->request->getPost('cliente'),
        'comentario'        =>$this->request->getPost('comentario'),
        'rateio'            =>$this->request->getPost('rateio'),
        ];
        $VendasModels = new VendasModel();
        $VendasModels->insert($this->venda);
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('vendas')); 
    }

    /**
     * Metodo para deletar um cliente
     */
    public function delete($id)
    {
        $VendasModels = new VendasModel();
        $VendasModels->delete($id);
        return redirect()->to(previous_url());
    }

    /**
     * Metodo para Consultar Cliente
     */
    public function consultar($id)
    {
        $data = $this->img();
        $VendasModels = new VendasModel();
        $data['venda'] = $VendasModels->find($id);
        return  view('venda/consultarVenda', $data);
    }

    /**
     * Metódo para atualizar os dados do cliente no Banco de Dados
     * 
     */
    public function atualizar($id)
    {
        $VendasModels = new VendasModel();
        $this->venda = [
        'venda'             =>$this->request->getPost('venda'),
        'vencimento_dt'     =>$this->request->getPost('vencimento_dt'),
        'valor'             =>$this->request->getPost('valor'),
        'categoria'         =>$this->request->getPost('categoria'),
        'fornecedor'        =>$this->request->getPost('fornecedor'),
        'comentario'        =>$this->request->getPost('comentario'),
        'rateio'            =>$this->request->getPost('rateio'),
        ];
        
        $VendasModels->update($id,$this->venda);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('vendas'));
    }

    /**
     * Metodo para receber por ajax em json
     * @return JSON
     */
    public function get_cliente($id)
    {
        $VendasModels = new VendasModel();
        $data = $VendasModels->where('id', $id)->first();
        return $this->response->setJSON($data);
    }
}
