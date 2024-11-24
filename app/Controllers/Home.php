<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index(): string
    {
        
        $data = $this->img();
        $data['permission'] = $this->permission();
        return view('dashboard', $data);
    }

}
