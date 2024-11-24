<?php

namespace App\Controllers;


class Livros extends BaseController
{
    public function index(): string
    {
        return view('livros');
    }

}
