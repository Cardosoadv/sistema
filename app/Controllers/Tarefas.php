<?php
/*
*Este ainda não esta configurado para este app.
*Controle já ajustado ao novo formato.
*TODO Ajustar ao novo app.


@ Autor:    Cardoso
@ Data:     05/05/2022
@ Versão:   0.0.1

*/

namespace App\Controllers;

use App\Models\TasksModel;
use App\Models\TaskStatusModel;

class Tarefas extends BaseController
{

    public function index()
    {
       //Inicio das funções do Tema. Não mexa aqui.
       if (!logged_in()) {
    return redirect()->to(base_url(route_to('login')));
    } //verifica se esta logado!
    $data = $this->tema();
    //Fim das funções do Tema
        $advogado = user_id();
        $data['title'] = lang('App.Tarefas.index');
        $TasksModel = new TasksModel();
        $data['tarefas'] = $TasksModel
            ->tarefas($advogado)
            ->getResultArray();

        $elementoPagina = new ElementosdePagina;
        $data['Responsaveis'] = $elementoPagina->comboAdvogados('responsavel[]');
      
       return view('tarefas', $data); 
    }

    public function salvartarefa()
    {
        if (!logged_in()) {
        return redirect()->to(base_url(route_to('login')));
        }
        $TasksModel = new TasksModel();
        
        $responsaveis = $this->request->getVar('responsavel[]');
        $data = [
            'task' => $this->request->getVar('task'),
            'prazo' => $this->request->getVar('prazo'),
            'prioridade' => $this->request->getVar('prioridade'),
            'detalhes'=> $this->request->getVar('detalhes'),
        ];

        $TasksModel->insert($data);
        $id=$TasksModel->getInsertID();
        $TasksModel->set_status_task($id);
        foreach ($responsaveis as $responsavel){
            $TasksModel->set_responsable_task($id,$responsavel);
        }
        return $this->response->redirect(site_url('tarefas'));

}

    public function deletetarefa($id = null)
    {
        if (!logged_in()) {
        return redirect()->to(base_url(route_to('login')));
        }
        $TasksModel = new TasksModel();
        $data = $TasksModel->where('id', $id)->delete($id);
        return $this->response->redirect(site_url('tarefas'));
    }

    public function ajax_editar_tarefa($id)
    {
        $TasksModel = new TasksModel();
        $data = $TasksModel->where('id', $id)->first();
     //   echo json_encode($data);
        return $this->response->setJSON($data);
    }

    public function ajax_responsaveis($id)
    {
        $TasksModel = new TasksModel();
        $data = $TasksModel->responsaveis($id)
        ->getResultArray();
     //   echo json_encode($data);
     return $this->response->setJSON($data); 
    }



    public function editartarefa($id)
    {
        if (!logged_in()) {
        return redirect()->to(base_url(route_to('login')));
        }
        $TasksModel = new TasksModel();
        $id = $this->request->getVar('id');
        $responsaveis = $this->request->getVar('responsavel');
        $data = [
            'task' => $this->request->getVar('task'),
            'prazo' => $this->request->getVar('prazo'),
            'prioridade' => $this->request->getVar('prioridade'),
            'detalhes'=> $this->request->getVar('detalhes')
        ];

        $TasksModel->update($id, $data);
        $TasksModel->delete_responsable($id);
        foreach ($responsaveis as $responsavel){
            $TasksModel->set_responsable_task($id,$responsavel);
        }
        return $this->response->redirect(site_url('tarefas'));
} 
 
    public function kanban(){
   
    //Inicio das funções do Tema. Não mexa aqui.
    if (!logged_in()) {
    return redirect()->to(base_url(route_to('login')));
    } //verifica se esta logado!
    $data = $this->tema();
    //Fim das funções do Tema
    $advogado = user_id();
    $data['title'] = lang('App.Tarefas.index');
    $TasksModel = new TasksModel();
        $data['backlogs']=$TasksModel
        ->tarefas_por_status($advogado,1)
        ->getResultArray();
        $data['a_fazers']=$TasksModel
        ->tarefas_por_status($advogado,2)
        ->getResultArray();
        $data['fazendos']=$TasksModel
        ->tarefas_por_status($advogado,3)
        ->getResultArray();
        $data['feitos']=$TasksModel
        ->tarefas_por_status($advogado,4)
        ->getResultArray();
        $data['cancelados']=$TasksModel
        ->tarefas_por_status($advogado,5)
        ->getResultArray();

        $elementoPagina = new ElementosdePagina;
        $data['Responsaveis'] = $elementoPagina->comboAdvogados('responsavel[]'); 

  //      echo '<pre>';
  //      print_r($data);

     return view('kanban/kanban', $data);
 }

 public function a_editar_status(){
    if (!logged_in()) {
    return redirect()->to(base_url(route_to('login')));
    }
    $TaskStatusModel = new TaskStatusModel();
    $id = $this->request->getVar('tarefa');
    $data = [
        "task_id"           =>$id, 
        "set_status_id"     =>$this->request->getVar('status')
    ];
    $TaskStatusModel->update($id, $data);

 }
}
