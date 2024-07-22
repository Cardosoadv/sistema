<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PessoasModel;
use App\Models\ProcessosModel;
use DateTime;

class Upload extends BaseController
{

    private array $processos = [
        'id_processo', 'processo', 'acao', 'numero',
        'juizo', 'vlr_causa', 'dt_distribuicao',
        'vlr_condenacao', 'comentarios'
    ];

    public function index()
    {
        $data = $this->img();
        
        return  view('importar', $data);
    }

    
    // Importar Clientes do csv
    public function importar()
    {
        
        $import = $_FILES['import'];
        if ($import['type'] === "text/csv") {
            $valuesImport = fopen($import['tmp_name'], "r");
            $i = 0;
            while ($linha = fgetcsv($valuesImport, 1000, ";")) {
                
                if ($i > 0) {
                $numeroProcesso = $linha[0];
                $juizo = $linha[2];
                $dt_distribuicao = $linha[3];
                $acao = $linha[4];
                $outraParte = $linha[5];
                $cliente = $linha[6];

                $PessoasModel = new PessoasModel();
                $cliente_id = $PessoasModel->verificarERegistrarCliente($cliente);
                $outraParte_id = $PessoasModel->verificarERegistrarCliente($outraParte);
                $ProcessosModel = new ProcessosModel();
                $processoExistente = $ProcessosModel->Where('numero', $numeroProcesso)->first();
                if(!$processoExistente){
                    $distribuicao_dt = DateTime::createFromFormat('dd/mm/YYYY',$dt_distribuicao);

                    $this->processos =[
                        'numero'          => $numeroProcesso,
                        'juizo'           => $juizo,
                        'dt_distribuicao' => date_format($distribuicao_dt, 'Y-m-d'),
                        'acao'            => $acao,
                    ];
                    $ProcessosModel->insert($this->processos);
                    $processoId = $ProcessosModel->getInsertID();
                    
                    //Adicionar Partes
                     
                    $cliente = [
                        'pessoa_id' => $cliente_id,
                        'processo_id' => $processoId,
                        'qualificacao' => 'Réu',
                        'e_cliente' => '1',
                    ];
                    $ProcessosModel->adicionarPartes($cliente);
                    $contraParte = [
                        'pessoa_id'         => $outraParte_id,
                        'processo_id'       => $processoId,
                        'qualificacao'      => 'Autor',
                        'e_cliente'         => '0',
                    ];
                    $ProcessosModel->adicionarPartes($contraParte);
                }    
                $i++;
                }else{
                    $i++;
                }
            }
            echo "Arquivo importado com sucesso!";
        }
    }

    public function receitas()
    {

        $import = $_FILES['import'];
        if ($import['type'] === "text/csv") {
            $valuesImport = fopen($import['tmp_name'], "r");
            helper('customDate');
            $i = 0;
            while ($linha = fgetcsv($valuesImport, 1000, ",")) {
                if ($i > 0) {
                    $preValor = str_replace(',', '.', str_replace('.', '', $linha[3]));
                    $data = [
                        'descricao' => mb_convert_encoding($linha[2], "UTF-8"),
                        'banco_id' => 1,
                        'rateio' => $linha[5],
                        'fat_emissao'  => importData($linha[0]),
                        'fat_vencimento' => importData($linha[1]),
                        'fat_valor'  => str_replace("R$", "", $preValor),
                    ];
                    $FaturasModel = new FaturasModel();
                    $FaturasModel->insert($data);

                    $i++;
                } else {
                    $_SESSION['msg'] = "O arquivo enviado não é CSV!";
                }
            }
            return $this->response->redirect(site_url('faturas'));
        }
    }
}
