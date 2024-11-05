<?php

namespace App\Controllers\Processos;

use App\Controllers\BaseController;



class Home extends BaseController
{
    public function index(): string
    {
        $data = $this->img();
        return view('dashboard', $data);
    }

}
