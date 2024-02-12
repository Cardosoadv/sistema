<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index(): string
    {
        $data = $this->img();
        return view('dashboard', $data);
    }

}
