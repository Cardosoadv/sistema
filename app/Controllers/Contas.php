<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ContasModel;


class Contas extends BaseController
{
    protected array $contas = [
        'conta', 'comentario'
    ];
    
    public function index()
    {
        
        $data = $this->img();
        $data['permission'] = $this->permission();
        $ContasModel = new ContasModel();

        $s = $this->request->getVar('s');
        if($s==null)
        {
        $data['contas'] = $ContasModel
            ->findAll();
        } else {
        $data['contas'] = $ContasModel
            ->like('conta',$s)
            ->findAll();
        }
        return  view('conta/contas', $data);
    }

    /**
     * Metodo para exibir o formulário de inserção de conta
     */
    public function novo(){
        
        $data = $this->img();
        $data['permission'] = $this->permission();
        return  view('conta/novaConta', $data);
    }

     /**
     * Metódo para salvar os dados do nova conta no Banco de Dados
     * 
     */
    public function adicionar()
    {
        $ContasModel = new ContasModel();
        $this->contas = [
            'conta'            =>$this->request->getPost('conta'),
            'comentario'       =>$this->request->getPost('comentario'),
        ];
        
        $ContasModel->insert($this->contas);
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);

        return $this->response->redirect(site_url('contas'));
    }

    /**
     * Metodo para deletar uma conta
     */
    public function delete($id)
    {
        $ContasModel = new ContasModel();
        $ContasModel->delete($id);
        return redirect()->to(previous_url());
    }

    
    /**
     * Metodo para Consultar Conta
     */
    public function consultar($id)
    {
        
        $data = $this->img();
        $data['permission'] = $this->permission();
        $ContasModel = new ContasModel();
        $data['conta'] = $ContasModel->find($id);
        return  view('conta/consultarConta', $data);
    }

    /**
     * Metódo para atualizar os dados da conta no Banco de Dados
     * 
     */
    public function atualizar($id)
    {
        $ContasModel = new ContasModel();
        $this->contas = [
            'conta'            =>$this->request->getPost('conta'),
            'comentario'       =>$this->request->getPost('comentario'),
        ];
        
        $ContasModel->update($id,$this->contas);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('contas'));
    }




    public function get_contas($id)
    {
        $ContasModel = new ContasModel();
        $data = $ContasModel->where('id', $id)->first();
        return $this->response->setJSON($data);
    }





}
