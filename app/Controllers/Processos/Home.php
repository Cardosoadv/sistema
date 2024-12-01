<?php

namespace App\Controllers\Processos;

use App\Controllers\BaseController;
use App\Models\ProcessosModel;
use App\Models\IntimacoesModel;
use App\Models\IntimacoesDestinatariosModel;
use App\Models\IntimacoesAdvogadosModel;



class Home extends BaseController
{

    private $processosModel, $intimacoesModel, $intimacoesDestinatariosModel, $intimacoesAdvogadosModel;

    public function __construct()
    {
        $this->processosModel                   = new ProcessosModel();
        $this->intimacoesModel                  = new IntimacoesModel();
        $this->intimacoesDestinatariosModel     = new IntimacoesDestinatariosModel();
        $this->intimacoesAdvogadosModel         = new IntimacoesAdvogadosModel();
    }

    public function index(): string
    {
        $data = $this->img();
        $data['permission'] = $this->permission();
        $data['processos'] = $this->processosModel->joinClientes();
        return view('dashboard', $data);
    }

}
