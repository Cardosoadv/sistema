<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VendasModel;
use DateTime;

class Vendas extends BaseController
{   
    private array $venda = [
        'venda',
        'vencimento_dt',
        'valor',
        'categoria',
        'cliente',
        'comentario',
        'rateio',
    ];
    
    //função para formatar a data. Ainda não foi testada.
    protected function novaData($data)
    {
    $novaData = date_format(new DateTime($data), 'Y-m-d');
    return $novaData;
    }

    public function index()
    {
        $data = $this->img();
        $VendasModels = new VendasModel();
        $s = $this->request->getVar('s');
        if($s==null)
        {
            $data['vendas'] = $VendasModels
            ->findAll();
        } else {
            $data['vendas'] = $VendasModels
            ->like('venda',$s)
            ->findAll();
        }
        
        return  view('venda/vendas', $data);
    }
    /**
     * Metodo para exibir o formulário de inserção de cliente
     */
    public function novo(){
        $data = $this->img();
        $Combo = new Combos();
        $data['cliente']= $Combo->comboClientes('cliente');
        $data['advogado']= $Combo->comboAdvogados('advogado[0]');
        $data['categoria']= $Combo->comboCategoria('categoria');
        return  view('venda/novaVenda', $data);
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
        
        $this->venda = [
        'venda'             =>$this->request->getPost('venda'),
        'vencimento_dt'     =>$this->request->getPost('vencimento_dt'),
        'valor'             =>$this->request->getPost('valor'),
        'categoria'         =>$this->request->getPost('categoria'),
        'conciliado'        =>$this->request->getPost('conciliado'),
        'cliente'           =>$this->request->getPost('cliente'),
        'comentario'        =>$this->request->getPost('comentario'),
        'rateio'            =>json_encode($rateioFormatado),
        ];
        $VendasModels = new VendasModel();
        $VendasModels->insert($this->venda);
        $msg = "Dados salvos com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('vendas')); 
    }

    /**
     * Metodo para deletar um cliente
     */
    public function delete($id)
    {
        $VendasModels = new VendasModel();
        $VendasModels->delete($id);
        return redirect()->to(previous_url());
    }

    /**
     * Metodo para Consultar Cliente
     */
    public function consultar($id)
    {
        $data = $this->img();
        $VendasModels = new VendasModel();
        $data['venda'] = $VendasModels->find($id);
        $rateio = json_decode($data['venda']['rateio'], true);
        $data['i'] = count($rateio);
        $Combo = new Combos();
        $i=0;
        foreach ($rateio as  $item) {
            $data['advogado'][$i] = $Combo->comboAdvogados('advogado['.$i.']', $item['advogado']);
            $data['rateio'][ $i] = $item['rateio'];
            $i++;
        }
        $data['cliente']= $Combo->comboClientes('cliente', $data['venda']['cliente']);
        $data['categoria']= $Combo->comboCategoria('categoria', $data['venda']['categoria']);
        return  view('venda/consultarVenda', $data);
    }

    /**
     * Metódo para atualizar os dados do cliente no Banco de Dados
     * 
     */
    public function atualizar($id)
    {
        $VendasModels = new VendasModel();
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
        $this->venda = [
        'venda'             =>$this->request->getPost('venda'),
        'vencimento_dt'     =>$this->request->getPost('vencimento_dt'),
        'valor'             =>$this->request->getPost('valor'),
        'categoria'         =>$this->request->getPost('categoria'),
        'cliente'            =>$this->request->getPost('cliente'),
        'comentario'        =>$this->request->getPost('comentario'),
        'rateio'            =>json_encode($rateioFormatado),
        ];
        
        $VendasModels->update($id,$this->venda);
        $msg = "Dados atualizados com sucesso!";
        $session = \Config\Services::session();
        $session->set($msg);
        return $this->response->redirect(site_url('vendas'));
    }

}
