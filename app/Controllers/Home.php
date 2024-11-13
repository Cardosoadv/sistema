<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index(): string
    {
        $data = $this->img();
        $permission['processos']=false;
        $data['permission'] = $permission;
        return view('dashboard', $data);
    }

}
