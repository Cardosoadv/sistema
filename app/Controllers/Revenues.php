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
        $data['UserOption1'] = $elementosPagina->comboUsuarios('user1');
        $data['UserOption2'] = $elementosPagina->comboUsuarios('user2');
        $data['UserOption3'] = $elementosPagina->comboUsuarios('user3');
        $data['UserOption4'] = $elementosPagina->comboUsuarios('user4');
        $data['UserOption5'] = $elementosPagina->comboUsuarios('user5');
        $data['UserOption6'] = $elementosPagina->comboUsuarios('user6');

        return  view('revenues', $data);
    }

    public function get_revenue($id)
    {
        $RevenuesModel = new RevenuesModel();
        $data = $RevenuesModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }


    public function adicionar()
    {
        $RevenuesModel = new RevenuesModel();
        $reconciled = ((($this->request->getPost('reconciled'))=="on")?1:0);
        $data = [
            'revenues'      =>     $this->request->getPost('revenues'),
            'due_dt'        =>     $this->novaData($this->request->getPost('due_dt')) ,
            'value'               =>     $this->request->getPost('value'),
            'category'            =>     $this->request->getPost('category_id'),
            'client_id'           =>     $this->request->getPost('client_id'),
            'reconciled'          =>     $reconciled,
            'comments'            =>     $this->request->getPost('comments'),
            'user1'               =>     $this->request->getPost('user1'),
            'user2'               =>     $this->request->getPost('user2'),
            'user3'               =>     $this->request->getPost('user3'),
            'user4'               =>     $this->request->getPost('user4'),
            'user5'               =>     $this->request->getPost('user5'),
            'user6'               =>     $this->request->getPost('user6'),
            'share_user1'         =>     $this->request->getPost('share_user1'),
            'share_user2'         =>     $this->request->getPost('share_user2'),
            'share_user3'         =>     $this->request->getPost('share_user3'),
            'share_user4'         =>     $this->request->getPost('share_user4'),
            'share_user5'         =>     $this->request->getPost('share_user5'),
            'share_user6'         =>     $this->request->getPost('share_user6'),
        ];           
        $RevenuesModel->insert($data);
        return $this->response->redirect(site_url('Revenues'));
    }

    public function atualizar($id)
    {
        $RevenuesModel = new RevenuesModel();
        $reconciled = ((($this->request->getPost('reconciled'))=="on")?1:0);        
        $data = [
            'revenues'      =>     $this->request->getPost('revenues'),
            'due_dt'        =>     $this->novaData($this->request->getPost('due_dt')) ,
            'value'               =>     $this->request->getPost('value'),
            'category'            =>     $this->request->getPost('category_id'),
            'client_id'           =>     $this->request->getPost('client_id'),
            'reconciled'          =>     $reconciled,
            'comments'            =>     $this->request->getPost('comments'),
            'user1'               =>     $this->request->getPost('user1'),
            'user2'               =>     $this->request->getPost('user2'),
            'user3'               =>     $this->request->getPost('user3'),
            'user4'               =>     $this->request->getPost('user4'),
            'user5'               =>     $this->request->getPost('user5'),
            'user6'               =>     $this->request->getPost('user6'),
            'share_user1'         =>     $this->request->getPost('share_user1'),
            'share_user2'         =>     $this->request->getPost('share_user2'),
            'share_user3'         =>     $this->request->getPost('share_user3'),
            'share_user4'         =>     $this->request->getPost('share_user4'),
            'share_user5'         =>     $this->request->getPost('share_user5'),
            'share_user6'         =>     $this->request->getPost('share_user6'),
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
