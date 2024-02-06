<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use DateTime;

class Accounts extends BaseController
{
    //função para formatar a data. Ainda não foi testada.
    protected function novaData($data)
    {
    $novaData = date_format(new DateTime($data), 'Y-m-d');
    return $novaData;
    }

    public function index()
    {
        $AccountsModel = new AccountsModel();
        $data['accounts'] = $AccountsModel
            ->get()->getResultArray();

        return  view('accounts', $data);
    }

    public function get_account($id)
    {
        $AccountsModel = new AccountsModel();
        $data = $AccountsModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }


    public function adicionar()
    {
        $AccountsModel = new AccountsModel();

        $data['account']         =  $this->request->getPost('account');
        $data['comments']      =  $this->request->getPost('comments');

        $AccountsModel->insert($data);
        return $this->response->redirect(site_url('accounts'));
    }

    public function atualizar($id)
    {
        $AccountsModel = new AccountsModel();
        $data = [
            'account'              =>  $this->request->getPost('account'),
            'comments'           =>  $this->request->getPost('comments')
        ];
        $AccountsModel->update($id,$data);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('accounts'));
    }

    public function delete($id)
    {
        $AccountsModel = new AccountsModel();
        $AccountsModel->delete($id);
        return $this->response->redirect(site_url('accounts'));
    }

}
