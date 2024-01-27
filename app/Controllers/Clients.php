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
        $ClientsModel = new ClientsModel();
        $data['clients'] = $ClientsModel
            ->get()->getResultArray();

        return  view('clients', $data);
    }

    
    //Falta testar esta função de adicionar
    public function adicionar()
    {
        $ClientsModel = new ClientsModel();

        $data['name']         =  $this->request->getPost('name');
        $data['celular']      =  $this->request->getPost('celular');
        $data['landed_at']    = $this->novaData($this->request->getPost('landed_at'));

        $ClientsModel->insert($data);
        return $this->response->redirect(site_url('clients'));

    }
}
