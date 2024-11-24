<?php

namespace App\Controllers\Processos;

use App\Controllers\BaseController;


class Teste extends BaseController
{
    public function index()
    {
        $data = "Teste com sucesso!";
        echo '<pre>';
        print_r($data);


    }

}