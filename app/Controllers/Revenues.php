<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RevenuesModel;
use DateTime;

class Revenues extends BaseController
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
        $RevenuesModel = new RevenuesModel();
        $data['revenues'] = $RevenuesModel
            ->orderBy('due_dt', 'asc')
            ->get()
            ->getResultArray()
            ;
        $elementosPagina = new ElementosPagina();
        $data['ClientsOption']  = $elementosPagina->comboClientes();
        $data['CategoryOption'] = $elementosPagina->comboCategory();
        $data['UserOption1'] = $elementosPagina->comboUsuarios('advogado[0]');
        $data['UserOption2'] = $elementosPagina->comboUsuarios('advogado[1]');
        $data['UserOption3'] = $elementosPagina->comboUsuarios('advogado[2]');
        $data['UserOption4'] = $elementosPagina->comboUsuarios('advogado[3]');
        $data['UserOption5'] = $elementosPagina->comboUsuarios('advogado[4]');
        $data['UserOption6'] = $elementosPagina->comboUsuarios('advogado[5]');

        return  view('revenues', $data);
    }

    public function get_client($id)
    {
        $RevenuesModel = new RevenuesModel();
        $data = $RevenuesModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }


    public function adicionar()
    {
        $RevenuesModel = new RevenuesModel();

        $data = [
            'revenues'      =>     $this->request->getPost('revenues'),
            'due_dt'        =>     $this->novaData($this->request->getPost('due_dt')) ,
            'value'         =>     $this->request->getPost('value'),
            'category'      =>     $this->request->getPost('category'),
            'client_id'     =>     $this->request->getPost('client_id'),
            'share'         =>     $this->request->getPost('share'),
            'reconciled'    =>     $this->request->getPost('reconciled'),
            'comments'      =>     $this->request->getPost('comments'),
        ];           
        $RevenuesModel->insert($data);
        return $this->response->redirect(site_url('Revenues'));

    }

    public function atualizar($id)
    {
        $RevenuesModel = new RevenuesModel();
        $data = [
            'revenues'      =>     $this->request->getPost('revenues'),
            'due_dt'        =>     $this->novaData($this->request->getPost('due_dt')) ,
            'value'         =>     $this->request->getPost('value'),
            'category'      =>     $this->request->getPost('category'),
            'client_id'     =>     $this->request->getPost('client_id'),
            'account_id'    =>     $this->request->getPost('account_id'),
            'share'         =>     $this->request->getPost('share'),
            'reconciled'    =>     $this->request->getPost('reconciled'),
            'comments'      =>     $this->request->getPost('comments'),
        ];
        $RevenuesModel->update($id,$data);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('Revenues'));
    }

    public function delete($id)
    {
        $RevenuesModel = new RevenuesModel();
        $RevenuesModel->delete($id);
        return redirect()->to(previous_url());

    }


}
