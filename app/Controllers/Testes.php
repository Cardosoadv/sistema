<?php

namespace App\Controllers;

use App\Models\RevenuesModel;
use App\Models\UserImgModel;


class Testes extends BaseController
{
    public function index()
    {
        $db = new RevenuesModel();
        $data = $db
        ->getOpenRevenues()
        ->getResultArray();
        echo '<pre>';
        print_r($data);


    }

}

