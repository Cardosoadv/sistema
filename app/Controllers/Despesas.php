<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DespesasModel;
use DateTime;


class Despesas extends BaseController
{   
    private array $despesa = [
        'despesa',
        'vencimento_dt',
        'valor',
        'categoria',
        'pessoa_id',
        'comentario',
        'rateio',
    ];
    
    //função para formatar a data. Ainda não foi testada.
    protected function novaData($data)
    {
    $novaData = date_format(new DateTime($data), 'Y-m-d');
    return $novaData;
    }
    /**
     * Metodo para exibir a lista de despesas
     */ 
    public function index()
    {
        $data = $this->img();
        $DespesasModels = new DespesasModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['despesas'] = $DespesasModels
            ->findAll();
            $data['vencidas'] = $DespesasModels
            ->despesasVencidas();
        } else {
            $data['despesas'] = $DespesasModels
            ->like('despesa',$s)
            ->findAll();
            $data['vencidas'] = $DespesasModels
            ->despesasVencidas($s);
        }
        
        return  view('despesa/despesas', $data);
    }
    /**
     * Metodo para exibir o formulário de inserção de despesa
     */
    public function novo(){
        $data = $this->img();
        $Combo = new Combos();
        $data['fornecedor']= $Combo->comboClientes('fornecedor');
        $data['advogado']= $Combo->comboAdvogados('advogado[0]');
        $data['categoria']= $Combo->comboCategoria('categoria');
        return  view('despesa/novaDespesa', $data);
    }

    /**
     * Metódo para salvar os dados do novo cliente no Banco de Dados
     * 
     */
    public function adicionar()
    {
        $advogado = $this->request->getPost('advogado[]');
        $rateio = $this->request->getPost('rateio[]');
        $num = count($advogado);
        $rateioFormatado=[];
        for ($i=0; $i < $num;$i++){
            $rateioFormatado[$i] = [
                'advogado' => $advogado[$i],
                'rateio' => $rateio[$i]
            ];
        }
        
        $this->despesa = [
        'despesa'           =>$this->request->getPost('despesa'),
        'vencimento_dt'     =>$this->request->getPost('vencimento_dt'),
        'valor'             =>$this->request->getPost('valor'),
        'categoria'         =>$this->request->getPost('categoria'),
        'pessoa_id'         =>$this->request->getPost('fornecedor'),
        'comentario'        =>$this->request->getPost('comentario'),
        'rateio'            =>json_encode($rateioFormatado),
        ];
        $DespesasModels = new DespesasModel();
        $DespesasModels->insert($this->despesa);
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('despesas')); 
    }

    /**
     * Metodo para deletar um cliente
     */
    public function delete($id)
    {
        $DespesasModels = new DespesasModel();
        $DespesasModels->delete($id);
        return $this->response->redirect(site_url('despesas'));
    }

    /**
     * Metodo para Consultar Despesa
     */
    public function consultar($id)
    {
        $data = $this->img();
        $DespesasModels = new DespesasModel();
        $data['despesas'] = $DespesasModels->find($id);
        $rateio = json_decode($data['venda']['rateio'], true);
        $data['i'] = count($rateio);
        $Combo = new Combos();
        $i=0;
        foreach ($rateio as  $item) {
            $data['advogado'][$i] = $Combo->comboAdvogados('advogado['.$i.']', $item['advogado']);
            $data['rateio'][ $i] = $item['rateio'];
            $i++;
        }
        $data['fornecedor']= $Combo->comboClientes('fornecedor', $data['despesas']['pessoa_id']);
        $data['categoria']= $Combo->comboCategoria('categoria', $data['despesas']['categoria']);
        return  view('despesa/consultarDespesa', $data);
    }

    /**
     * Metódo para atualizar os dados da venda no Banco de Dados
     * 
     */
    public function atualizar($id)
    {
        $DespesasModels = new DespesasModel();
        $advogado = $this->request->getPost('advogado[]');
        $rateio = $this->request->getPost('rateio[]');
        $num = count($advogado);
        $rateioFormatado=[];
        for ($i=0; $i < $num;$i++){
            $rateioFormatado[$i] = [
                'advogado' => $advogado[$i],
                'rateio' => $rateio[$i]
            ];
        }
        $this->despesa = [
        'despesa'           =>$this->request->getPost('despesa'),
        'vencimento_dt'     =>$this->request->getPost('vencimento_dt'),
        'valor'             =>$this->request->getPost('valor'),
        'categoria'         =>$this->request->getPost('categoria'),
        'pessoa_id'         =>$this->request->getPost('fornecedor'),
        'comentario'        =>$this->request->getPost('comentario'),
        'rateio'            =>json_encode($rateioFormatado),
        ];
        
        $DespesasModels->update($id,$this->despesa);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('despesas'));
    }

    public function testar(){
        $Model = new DespesasModel();
        $data = $Model->despesasVencidas();
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    }

}
