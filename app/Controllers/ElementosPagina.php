<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
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
            $arrayCategorias[$category['id']] = $category['category'];
        }
        return $data['comboCategories'] = form_dropdown($nome, $arrayCategorias, '', 'class="form-control" style="width: 100%;"');
    }

    public function comboAccount($nome = 'account_id')
    {
        $AccountsModel = new AccountsModel();
        $accounts = $AccountsModel->findAll();
        helper('form');
        $Newarray = ["Selecione a Conta"]; 
        foreach ($accounts as $account) {
            $arrayCategorias[$account['id']] = $account['account'];
        }
        return $data['comboAccount'] = form_dropdown($nome, $Newarray, '', 'class="form-control" style="width: 100%;"');
    }

    public function comboUsuarios($nome = 'user_id')
    {
        $UserModel = new UserModel();
        $usuarios = $UserModel->findAll();
        helper('form');
        $newArray = ["Selecione o usuario"];
        foreach ($usuarios as $usuario) {
            $newArray[$usuario['id']] = $usuario['username'];
        }
        return $data['comboUsuarios'] = form_dropdown($nome, $newArray, '', 'class="form-control mt-1" style="width: 100%;"');
    }

    public function ArrayComboUsuarios($nomes = ['user_id'])
    {
        $UserModel = new UserModel();
        $usuarios = $UserModel->findAll();
        helper('form');
        $newArray = ["Selecione o usuario"];
        foreach ($usuarios as $usuario) {
            $newArray[$usuario['id']] = $usuario['username'];
        }
        $data = [];
        foreach ($nomes as $nome){
            array_push($data, form_dropdown($nome, $newArray, '', 'class="form-control mt-1" style="width: 100%;"'));
        };
        return $data;
    }


}