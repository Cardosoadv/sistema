<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\CodeIgniter\BaseModel;
use App\Models\IntimacoesModel;
use App\Models\IntimacoesDestinatariosModel;
use App\Models\IntimacoesAdvogadosModel;
use Exception;

class Intimacoes extends BaseController
{


    public function index(){

        $this->getIntimacoes("164136","mg");
    
    }

    public function parseIntimacao(array $data){

        $resultadoIntimacoes = [];
        $intimacoesModel = new IntimacoesModel();
        $intimacoesDestinatariosModel = new IntimacoesDestinatariosModel();
        $intimacoesAdvogadosModel = new IntimacoesAdvogadosModel();

        foreach($data['items'] as $items){
            //Binding capos da intimação
            $intimacao = [
                'id_intimacao'              => $items['id'],
                'data_disponibilizacao'     => $items['data_disponibilizacao'],
                'siglaTribunal'             => $items['siglaTribunal'],
                'tipoComunicacao'           => $items['tipoComunicacao'],
                'nomeOrgao'                 => $items['nomeOrgao'],
                'texto'                     => $items['texto'],
                'numero_processo'           => $items['numero_processo'],
                'meio'                      => $items['meio'],
                'link'                      => $items['link'],
                'tipoDocumento'             => $items['tipoDocumento'],
                'codigoClasse'              => $items['codigoClasse'],
                'numeroComunicacao'         => $items['numeroComunicacao'],
                'ativo'                     => ($items['ativo'])?1:0,
                'hash'                      => $items['hash'],
                'status'                    => $items['status'],
                'motivo_cancelamento'       => $items['motivo_cancelamento'],
                'data_cancelamento'         => $items['data_cancelamento'],
                'datadisponibilizacao'      => $items['datadisponibilizacao'],
                'dataenvio'                 => $items['dataenvio'],
                'meiocompleto'              => $items['meiocompleto'],
                'numeroprocessocommascara'  => $items['numeroprocessocommascara'],
            ];


            if($intimacoesModel->exitingIntimacao($items['id'])){
                
                echo "id ".$items['id']." Já Registrado \n.";
                
            }else{
                try {

                    //Registra as intimações no db
                    $intimacoesModel->insert($intimacao);
                    
                    array_push($resultadoIntimacoes, $intimacoesModel->getInsertID());

                    //Percorre a lista de destinários salvando cada uma no db
                    foreach($items['destinatarios'] as $itemsDestinatario){
                        $destinatarios = [
                            'comunicacao_id' => $itemsDestinatario['id_intimacao'],
                            'nome'           => $itemsDestinatario['id_intimacao'],
                            'polo'           => $itemsDestinatario['id_intimacao'],
                        ];
                        $intimacoesDestinatariosModel->insert($destinatarios);
                    }

                    //Percorre a lista de advogados salvando cada uma no db
                    foreach($items['advogados'] as $itemsAdvogados){
                        $advogados = [
                            'id'                => $itemsAdvogados['id'],
                            'comunicacao_id'    => $itemsAdvogados['comunicacao_id'],
                            'advogado_id'       => $itemsAdvogados['advogado_id'],    
                            'advogado_nome'     => $itemsAdvogados['advogado_nome'],
                            'advogado_oab'      => $itemsAdvogados['advogado_oab'],
                            'advogado_oab_uf'   => $itemsAdvogados['advogado_oab_uf'],
                            'created_at'        => $itemsAdvogados['created_at'],
                            'updated_at'        => $itemsAdvogados['updated_at']
                        ];
                        $intimacoesAdvogadosModel->insert($advogados);

                        }
                    } catch (Exception $e) {
                        //Desfaz operações em caso de erro.

                        // Registrar erro em um log
                        error_log("Erro ao salvar intimação: " . $e->getMessage());
                    }

                }
        }

        echo '<pre>';
        print_r($resultadoIntimacoes);
        echo '</pre>';
        
        //return view('testes');

    }

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
