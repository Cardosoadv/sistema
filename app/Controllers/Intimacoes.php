<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Debug;
use App\Libraries\ReceberIntimacoes;
use App\Models\IntimacoesModel;
use App\Models\IntimacoesDestinatariosModel;
use App\Models\IntimacoesAdvogadosModel;
use App\Models\ProcessosAdvogadosModel;
use App\Models\ProcessosModel;
use App\Models\ProcessosMovimentoModel;
use App\Models\ProcessosPartesModel;
use CodeIgniter\Log\Logger;
use Exception;

class Intimacoes extends BaseController
{

    public function index(){

        $data = $this->img();
        $data['permission'] = $this->permission();
        $receberIntimacoes = new ReceberIntimacoes();
        $receberIntimacoes->getIntimacoes("164136", "MG");

        $intimacoesModel = new IntimacoesModel();
        $data['intimacoes'] = $intimacoesModel->getIntimacoesNaoTratadas();
        return view('intimacoes', $data);
    }

    public function testar(){
        $receberIntimacoes = new ReceberIntimacoes();
        $data = $receberIntimacoes->getIntimacoes("164136", "MG");

    }

    public function buscarintimacoes($nomeParte){

        $this->getIntimacoesPeloNomeParte($nomeParte);

        return redirect()->to('intimacoes');
    }


    public function tratarIntimacoes(){
        
        $ids = $this->request->getPost('intimacoes[]');
        
        foreach ($ids as $id){

            $intimacoesModel                  = new IntimacoesModel();
            $intimacoesDestinatariosModel     = new IntimacoesDestinatariosModel();
            $intimacoesAdvogadosModel         = new IntimacoesAdvogadosModel();
            $debug                            = new Debug();
    
            $intimacao  = $intimacoesModel->where("id_intimacao", $id)->first();
            $advogados  = $intimacoesAdvogadosModel->where("comunicacao_id", $id)->get()->getResultArray();
            $partes     = $intimacoesDestinatariosModel->where("comunicacao_id", $id)->get()->getResultArray(); 

            $debug->debug($intimacao);
            $debug->debug($advogados);
            $debug->debug($partes);

            $processosModel                   = new ProcessosModel();
            $processosMovimentoModel          = new ProcessosMovimentoModel();
            $processosPartesModel             = new ProcessosPartesModel();
            $processosAdvogadosModel          = new ProcessosAdvogadosModel();
    
            
            if (! $processosModel->exitingProcesso($intimacao['numero_processo'])){
                
                $processosModel->salvarProcesso($intimacao);

                $intimacao['processo_id'] = $processosModel->getInsertID();
                echo $intimacao['processo_id'];

                
                $processosMovimentoModel->salvarMovimento($intimacao);


                    foreach ($advogados as $advogado){
                        
                        $processosAdvogadosModel->salvarAdvogados($advogado,$intimacao['processo_id']);
                    }

                    foreach ($partes as $parte){

                            $processosPartesModel->salvarParte($parte,$intimacao['processo_id']);
                    
                    }


                $intimacoesModel->update($intimacao['id_intimacao'], 'statusTratamento', 1);

            }else{

                echo "processo já salvo";  
            
            }
            
        }
 
    }

    /**
     * Efetua o tratamento das intimações organizando os dados e salvandos nas tabelas corretas
     */
    public function parseIntimacao(array $data){

            $intimacoesModel                  = new IntimacoesModel();
            $intimacoesDestinatariosModel     = new IntimacoesDestinatariosModel();
            $intimacoesAdvogadosModel         = new IntimacoesAdvogadosModel();
    
        foreach($data['items'] as $items){

            //Verifica se a intimaçã já foi registrada no db
            if($intimacoesModel->exitingIntimacao($items['id'])){
                
                $data['msg'] = "id ".$items['id']." Já Registrado \n.";
                
            }else{

                    //Registra as intimações no db
                    $intimacoesModel->salvarIntimacoes($items);

                    //Percorre a lista de destinários salvando cada uma no db
                    foreach($items['destinatarios'] as $itemsDestinatario){
                        $intimacoesDestinatariosModel->salvarDestinatarios($itemsDestinatario);
                    }

                    //Percorre a lista de advogados salvando cada uma no db
                    foreach($items['destinatarioadvogados'] as $itemsAdvogados){
                        $intimacoesAdvogadosModel->salvarAdvogados($itemsAdvogados);
                        }
            }            
                
        }
        $msg['msg']= "Sucesso no salvamento das intimações";
        return view('testes', $msg);
    }

        /**
     * Função para buscar as intimações no DJEN
     * @param string $nomeParte
     */
    public function getIntimacoesPeloNomeParte($nomeParte){

        $nomeParteFormatado = str_replace($nomeParte, ' ', '%20');
        $apiUrl = 'https://hcomunicaapi.cnj.jus.br/api/v1/comunicacao';
        $params = [
            'nomeParte' => $nomeParteFormatado,
        ];
        
        // Construindo a URL com os parâmetros
        $query = http_build_query($params);
        $apiUrl .= '?' . $query;

        // Iniciando a sessão cURL
        $ch = curl_init();
        
        // Configurando as opções da requisição
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);
        
        // Verifica se houve algum erro
        if(curl_errno($ch)){
            echo 'Erro na requisição: ' . curl_error($ch);
        } else {
            // Processa a resposta da API
            $data = json_decode($response, true);
            if ($data['status']=="success"){
                $this->parseIntimacao($data);
            }else{
                $s = $data;
                return view('testes',$s); 
            }
        }
        // Fecha a sessão cURL
        curl_close($ch);
    }




}
