<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RevenuesModel;
use App\Models\ReceiptsRevenuesModel;
use DateTime;

class Revenues extends BaseController
{
    //função para formatar a data. Ainda não foi testada.
    protected function novaData($data)
    {
    $novaData = date_format(new DateTime($data), 'Y-m-d');
    return $novaData;
    }

    protected function isExpired($due_dt){
        $hoje = new DateTime();
        $dueDate = new DateTime($due_dt);
        return ($dueDate > $hoje);
    }

    public function index()
    {
        
        $data = $this->img();
        $data['permission'] = $this->permission();
        $RevenuesModel = new RevenuesModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
        $data['revenues'] = $RevenuesModel
            ->orderBy('due_dt', 'asc')
            ->get()
            ->getResultArray();
        }else{
            $data['revenues'] = $RevenuesModel
            ->like('revenues',$s)
            ->get()
            ->getResultArray();
        }
        $elementosPagina = new ElementosPagina();
        $data['ClientsOption']  = $elementosPagina->comboClientes();
        $data['CategoryOption'] = $elementosPagina->comboCategory();
        $comboUsuarios = $elementosPagina->ArrayComboUsuarios(['user1','user2','user3','user4','user5','user6','receipt_user1','receipt_user2','receipt_user3','receipt_user4','receipt_user5','receipt_user6']);
        $data['UserOption1'] = $comboUsuarios[0];
        $data['UserOption2'] = $comboUsuarios[1];
        $data['UserOption3'] = $comboUsuarios[2];
        $data['UserOption4'] = $comboUsuarios[3];
        $data['UserOption5'] = $comboUsuarios[4];
        $data['UserOption6'] = $comboUsuarios[5];
        $data['ReceiptUserOption1'] = $comboUsuarios[6];
        $data['ReceiptUserOption2'] = $comboUsuarios[7];
        $data['ReceiptUserOption3'] = $comboUsuarios[8];
        $data['ReceiptUserOption4'] = $comboUsuarios[9];
        $data['ReceiptUserOption5'] = $comboUsuarios[10];
        $data['ReceiptUserOption6'] = $comboUsuarios[11];
        $data['AccountOption'] = $elementosPagina->comboAccount('account_id');

    return  view('revenues', $data);
    }

    public function get_revenue($id)
    {
        $RevenuesModel = new RevenuesModel();
        $data = $RevenuesModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }

    public function get_receipts($id)
    {
        $ReceiptsRevenuesModel = new ReceiptsRevenuesModel();
        $data = $ReceiptsRevenuesModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }

    public function receber($id)
    {
  
        return $id; 
    }


    public function adicionar()
    {
        $RevenuesModel = new RevenuesModel();
        $reconciled = ((($this->request->getPost('reconciled'))=="on")?1:0);
        $data = [
            'revenues'            =>     $this->request->getPost('revenues'),
            'due_dt'              =>     $this->novaData($this->request->getPost('due_dt')) ,
            'value'               =>     $this->request->getPost('value'),
            'category'            =>     $this->request->getPost('category_id'),
            'client_id'           =>     $this->request->getPost('client_id'),
            'reconciled'          =>     $reconciled,
            'comments'            =>     $this->request->getPost('comments'),
            'late_fee'            =>     $this->request->getPost('late_fee'),
            'interest'            =>     $this->request->getPost('interest'),
            'charges'             =>     $this->request->getPost('charges'),
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
        $msg = "Dados inseridos com sucesso!";
        $session = \Config\Services::session();
        $session->set('msg',$msg);
        return $this->response->redirect(site_url('Revenues'));
    }

    public function atualizar($id)
    {
        $RevenuesModel = new RevenuesModel();
        $reconciled = ((($this->request->getPost('reconciled'))=="on")?1:0);        
        $data = [
            'revenues'            =>     $this->request->getPost('revenues'),
            'due_dt'              =>     $this->novaData($this->request->getPost('due_dt')) ,
            'value'               =>     $this->request->getPost('value'),
            'category'            =>     $this->request->getPost('category_id'),
            'client_id'           =>     $this->request->getPost('client_id'),
            'reconciled'          =>     $reconciled,
            'comments'            =>     $this->request->getPost('comments'),
            'late_fee'            =>     $this->request->getPost('late_fee'),
            'interest'            =>     $this->request->getPost('interest'),
            'charges'             =>     $this->request->getPost('charges'),
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
        $session->set('msg',$msg);
        return $this->response->redirect(site_url('Revenues'));
    }

    public function delete($id)
    {
        $RevenuesModel = new RevenuesModel();
        $RevenuesModel->delete($id);
        return redirect()->to(previous_url());

    }


}
