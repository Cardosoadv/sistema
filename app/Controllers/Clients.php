<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientsModel;
use DateTime;

class Clients extends BaseController
{
    //função para formatar a data. Ainda não foi testada.
    protected function novaData($data)
    {
    $novaData = date_format(new DateTime($data), 'Y-m-d');
    return $novaData;
    }
 
    public function index()
    {
        $data = $this->img();
        $ClientsModel = new ClientsModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['clients'] = $ClientsModel
            ->get()
            ->getResultArray();
        } else {
            $data['clients'] = $ClientsModel
            ->like('name',$s)
            ->get()
            ->getResultArray();
        }
        return  view('clients', $data);
    }

    public function get_client($id)
    {
        $ClientsModel = new ClientsModel();
        $data = $ClientsModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }


    public function adicionar()
    {
        $ClientsModel = new ClientsModel();

        $data['name']         =  $this->request->getPost('name');
        $data['celular']      =  $this->request->getPost('celular');
        $data['email']      =  $this->request->getPost('email');
        $data['landed_at']    = $this->novaData($this->request->getPost('landed_at'));

        $ClientsModel->insert($data);
        return $this->response->redirect(site_url('clients'));

    }

    public function atualizar($id)
    {
        $ClientsModel = new ClientsModel();
        $data = [
            'name'              =>  $this->request->getPost('name'),
            'celular'           =>  $this->request->getPost('celular'),
            'email'             =>  $this->request->getPost('email'),
            'landed_at'         =>  $this->novaData($this->request->getPost('landed_at'))
        ];
        $ClientsModel->update($id,$data);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('clients'));
    }

    public function delete($id)
    {
        $ClientsModel = new ClientsModel();
        $ClientsModel->delete($id);
        return redirect()->to(previous_url());

    }


}
