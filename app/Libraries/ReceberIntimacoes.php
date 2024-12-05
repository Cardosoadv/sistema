<?php

namespace App\Libraries;

use App\Controllers\Intimacoes;
use Exception;

class ReceberIntimacoes{

        private $intimacao;

        public function __construct(){
            $this->intimacao = new Intimacoes();
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

                
            // Generate a unique filename
            $filename = $this->generateFilename($oab, $ufOab);
                
            // Save JSON to file
            $this->saveJsonToFile($filename, $response);

            $this->intimacao->parseIntimacao($data);

            }else{
                $s = $data;
                return view('testes',$s); 
            }
        }
        // Fecha a sessão cURL
        curl_close($ch);
}

/**
 * Generate a unique filename for the JSON file
 * 
 * @param string $oab Lawyer's OAB number
 * @param string $ufOab OAB state
 * @return string Filename path
 */
private function generateFilename($oab, $ufOab) {
    // Create storage directory if it doesn't exist

    
    // Construindo o caminho completo para o arquivo ou pasta dentro do diretório de armazenamento
    $storagePath = WRITEPATH . '/intimacao_json';
    
    // Salvando um arquivo
    
    //file_put_contents($filepath, 'Conteúdo do arquivo');

    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
    }
    
    // Generate filename with timestamp and OAB details
    $timestamp = date('YmdHis');
    $filename = "{$storagePath}/{$timestamp}.json";
    
    return $filename;
}

/**
 * Save JSON response to file
 * 
 * @param string $filename Full path to save the file
 * @param string $jsonContent JSON content to save
 * @throws Exception If file cannot be saved
 */
private function saveJsonToFile($filename, $jsonContent) {
    // Attempt to write the file
    $result = file_put_contents($filename, $jsonContent);
    
    if ($result === false) {
        throw new Exception("Unable to save JSON file: {$filename}");
    }
}


}