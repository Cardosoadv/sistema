<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExpensesModel;
use App\Models\PaymentsExpensesModel;
use DateTime;

class Expenses extends BaseController
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
        $ExpensesModel = new ExpensesModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
        $data['expenses'] = $ExpensesModel
            ->orderBy('due_dt', 'asc')
            ->get()
            ->getResultArray();
        }else{
            $data['expenses'] = $ExpensesModel
            ->like('expenses',$s)
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
        $data['PaymentUserOption1'] = $comboUsuarios[6];
        $data['PaymentUserOption2'] = $comboUsuarios[7];
        $data['PaymentUserOption3'] = $comboUsuarios[8];
        $data['PaymentUserOption4'] = $comboUsuarios[9];
        $data['PaymentUserOption5'] = $comboUsuarios[10];
        $data['PaymentUserOption6'] = $comboUsuarios[11];
        $data['AccountOption'] = $elementosPagina->comboAccount('account_id');

    return  view('expenses', $data);
    }

    public function get_expense($id)
    {
        $ExpensesModel = new ExpensesModel();
        $data = $ExpensesModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }

    public function get_payments($id)
    {
        $PaymentsExpensesModel = new PaymentsExpensesModel();
        $data = $PaymentsExpensesModel->where('id', $id)->first();
               return $this->response->setJSON($data);
    }

    public function pagar($id)
    {
        //TODO função par receber a venda
        return $id; 
    }


    public function adicionar()
    {
        $ExpensesModel = new ExpensesModel();
        $reconciled = ((($this->request->getPost('reconciled'))=="on")?1:0);
        $data = [
            'expenses'            =>     $this->request->getPost('expenses'),
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
        $ExpensesModel->insert($data);
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set('msg',$msg);
        return $this->response->redirect(site_url('expenses'));
    }

    public function atualizar($id)
    {
        $ExpensesModel = new ExpensesModel();
        $reconciled = ((($this->request->getPost('reconciled'))=="on")?1:0);        
        $data = [
            'expenses'            =>     $this->request->getPost('expenses'),
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
        $ExpensesModel->update($id,$data);
        $msg = 'Dados atualizados com sucesso!';
        $session = \Config\Services::session();
        $session->set('msg',$msg);
        return $this->response->redirect(site_url('expenses'));
    }

    public function delete($id)
    {
        $ExpensesModel = new ExpensesModel();
        $ExpensesModel->delete($id);
        return redirect()->to(previous_url());

    }


}
