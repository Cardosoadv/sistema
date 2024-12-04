<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Debug;
use App\Models\IntimacoesModel;
use App\Models\IntimacoesDestinatariosModel;
use App\Models\IntimacoesAdvogadosModel;
use App\Models\ProcessosModel;
use App\Models\ProcessosMovimentoModel;
use App\Models\ProcessosPartesModel;
use Exception;

class Intimacoes extends BaseController
{
    // Injeta os Models via construtor.
    private $intimacoesModel,$intimacoesDestinatariosModel,$intimacoesAdvogadosModel;
    private $processosModel;
    private $processosMovimentoModel;
    private $processosPartesModel;
    private $debug;

    public function __construct(){

    $this->intimacoesModel                  = new IntimacoesModel();
    $this->intimacoesDestinatariosModel     = new IntimacoesDestinatariosModel();
    $this->intimacoesAdvogadosModel         = new IntimacoesAdvogadosModel();
    $this->processosModel                   = new ProcessosModel();
    $this->processosMovimentoModel          = new ProcessosMovimentoModel();
    $this->processosPartesModel             = new ProcessosPartesModel();
    $this->debug                            = new Debug();
        
    }

    public function index(){

        $data = $this->img();
        $data['permission'] = $this->permission();
        $this->getIntimacoes("164136", "MG");
        $this->getIntimacoes("61061", "MG");

        $data['intimacoes'] = $this->intimacoesModel->getIntimacoesNaoTratadas();
        return view('intimacoes', $data);
    }

    public function buscarintimacoes($nomeParte){

        $this->getIntimacoesPeloNomeParte($nomeParte);

        return redirect()->to('intimacoes');
    }


    public function tratarIntimacoes(){
        
        $ids = $this->request->getPost('intimacoes[]');
        
        foreach ($ids as $id){
           
            $intimacao  = $this->intimacoesModel->where("id_intimacao", $id)->first();
            $advogados  = $this->intimacoesAdvogadosModel->where("comunicacao_id", $id)->get()->getResultArray();
            $partes     = $this->intimacoesDestinatariosModel->where("comunicacao_id", $id)->get()->getResultArray(); 
            $this->debug->debug($intimacao);
            $this->debug->debug($advogados);
            $this->debug->debug($partes);
            
            if (! $this->processosModel->exitingProcesso($intimacao['numero_processo'])){
                
                $this->processosModel->salvarProcesso($intimacao);

                $intimacao['processo_id'] = $this->processosModel->getInsertID();
                echo $intimacao['processo_id'];

                
                $this->processosMovimentoModel->salvarMovimento($intimacao);
)

                    foreach ($advogados as $advogado){
                        
                        $this->processosAdvogadosModel->salvarAdvogados($advogado,$intimacao['processo_id']);
                    }

                    foreach ($partes as $parte){

                            $this->processosPartesModel->salvarParte($parte,$intimacao['processo_id']);
                    
                    }
                         

                $this->intimacoesModel->update($intimacao['id_intimacao'], 'statusTratamento', 1);

            }else{

                echo "processo já salvo";  
            
            }
            
        }
 
    }

    /**
     * Efetua o tratamento das intimações organizando os dados e salvandos nas tabelas corretas
     */
    public function parseIntimacao(array $data){

        foreach($data['items'] as $items){

            //Verifica se a intimaçã já foi registrada no db
            if($this->intimacoesModel->exitingIntimacao($items['id'])){
                
                echo "id ".$items['id']." Já Registrado \n.";
                
            }else{

                    //Registra as intimações no db
                    $this->intimacoesModel->salvarIntimacoes($items);

                    //Percorre a lista de destinários salvando cada uma no db
                    foreach($items['destinatarios'] as $itemsDestinatario){
                        $this->intimacoesDestinatariosModel->salvarDestinatarios($itemsDestinatario);
                    }

                    //Percorre a lista de advogados salvando cada uma no db
                    foreach($items['destinatarioadvogados'] as $itemsAdvogados){
                        $this->intimacoesAdvogadosModel->salvarAdvogados($itemsAdvogados);
                        }
            }            
                
        }
        $msg['msg']= "Sucesso no salvamento das intimações";
        return view('testes', $msg);
    }

    /**
     * Função para buscar as intimações no DJEN
     * @param string $oab
     * @param string $ufOab
     */
    public function getIntimacoes($oab, $ufOab){

        $apiUrl = 'https://hcomunicaapi.cnj.jus.br/api/v1/comunicacao';
        $params = [
            'numeroOab' => $oab,
            'ufOab' => $ufOab
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
