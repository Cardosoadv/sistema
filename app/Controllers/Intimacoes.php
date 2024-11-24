<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IntimacoesModel;
use App\Models\IntimacoesDestinatariosModel;
use App\Models\IntimacoesAdvogadosModel;
use Exception;

class Intimacoes extends BaseController
{
    // Injeta os Models via construtor.
    private $intimacoesModel,$intimacoesDestinatariosModel,$intimacoesAdvogadosModel;

    public function __construct(){

    $this->intimacoesModel                  = new IntimacoesModel();
    $this->intimacoesDestinatariosModel     = new IntimacoesDestinatariosModel();
    $this->intimacoesAdvogadosModel         = new IntimacoesAdvogadosModel();
        
    }

    public function index(){

        $data = $this->img();
        $data['permission'] = $this->permission();
        $data['intimacoes'] = $this->intimacoesModel->getIntimacoesNaoTratadas();
        return view('intimacoes', $data);
    }

    public function tratarIntimacoes(){

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
}
