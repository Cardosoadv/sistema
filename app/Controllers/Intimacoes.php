<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

        foreach($data['items'] as $items){

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

            $destinatarios = $items['destinatarios'];
            $advogados     = $items['destinatarioadvogados'];

            $intimacoesModel = new IntimacoesModel();
            $intimacoesDestinatariosModel = new IntimacoesDestinatariosModel();
            $intimacoesAdvogadosModel = new IntimacoesAdvogadosModel();

            if($intimacoesModel->exitingIntimacao($items['id'])){

                echo "id ".$items['id']." Já Registrado \n.";

            }else{

                $intimacoesDestinatariosModel->insert($destinatarios);
                    $intimacoesAdvogadosModel->insert($advogados);
                    $intimacoesModel->insert($intimacao);    
                

            }
        }
        return view('testes');
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
            $this->parseIntimacao($data);
        }
        
        // Fecha a sessão cURL
        curl_close($ch);
    }
    
 

}
