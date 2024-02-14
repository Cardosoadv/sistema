<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ClientsModel;
use App\Models\UserModel;

class ElementosPagina extends BaseController
{

public function comboClientes($nome = 'client_id')
    {
        $ClientsModel = new ClientsModel();
        $clientes = $ClientsModel->findAll();
        helper('form');
        $arrayClientes = ["Selecione o Cliente"];
        foreach ($clientes as $cliente) {
            $arrayClientes[$cliente['id']] = $cliente['name'];
        }
        return $data['comboClientes'] = form_dropdown($nome, $arrayClientes, '', 'class="form-control" style="width: 100%;"');
    }

    public function comboCategory($nome = 'category_id')
    {
        $CategoryModel = new CategoryModel();
        $categories = $CategoryModel->findAll();
        helper('form');
        $arrayCategorias = ["Selecione a Categoria"];
        foreach ($categories as $category) {
            $arrayCategorias[$category['id']] = $category['name'];
        }
        return $data['comboCategories'] = form_dropdown($nome, $arrayCategorias, '', 'class="form-control" style="width: 100%;"');
    }

    public function comboUsuarios($nome = 'user_id')
    {
        $UserModel = new UserModel();
        $usuarios = $UserModel->findAll();
        helper('form');
        $arrayUsuarios = ["Selecione o usuario"];
        foreach ($usuarios as $usuario) {
            $arrayUsuarios[$usuario['id']] = $usuario['username'];
        }
        return $data['comboUsuarios'] = form_dropdown($nome, $arrayUsuarios, '', 'class="form-control mt-1" style="width: 100%;"');
    }


}