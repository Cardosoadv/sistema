<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\CategoriasModel;
use App\Models\ClientesModel;
use App\Models\UserModel;
/**
 * Fornece combos para serem reutilizados em todo sistema
 */
class Combos extends BaseController
{

public function comboClientes($nome = 'cliente', $selected='')
    {
        $ClientesModel = new ClientesModel();
        $clientes = $ClientesModel->findAll();
        helper('form');
        $arrayClientes = ["Selecione o Cliente"];
        foreach ($clientes as $cliente) {
            $arrayClientes[$cliente['id_pessoa']] = $cliente['nome'];
        }
        return $data['comboClientes'] = form_dropdown($nome, $arrayClientes, $selected, 'class="form-control" style="width: 100%;"');
    }

    public function comboAdvogados($nome = 'advogados', $selected='')
    {
        $ClientesModel = new ClientesModel();
        $clientes = $ClientesModel->findAll();
        helper('form');
        $arrayClientes = ["Selecione o Advogado"];
        foreach ($clientes as $cliente) {
            $arrayClientes[$cliente['id_pessoa']] = $cliente['nome'];
        }
        return $data['comboClientes'] = form_dropdown($nome, $arrayClientes, $selected, 'class="form-control mt-1" style="width: 100%;"');
    }


    public function comboCategoria($nome = 'categoria', $selected='')
    {
        $CategoriasModel = new CategoriasModel();
        $categorias = $CategoriasModel->findAll();
        helper('form');
        $arrayCategorias = ["Selecione a Categoria"]; 
        foreach ($categorias as $categoria) {
            $arrayCategorias[$categoria['id_categoria']] = $categoria['categoria'];
        }
        return $data['comboCategorias'] = form_dropdown($nome, $arrayCategorias, $selected, 'class="form-control" style="width: 100%;"');
    }

    public function comboAccount($nome = 'account_id') //TODO Ajustar combo
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

    public function comboUsuarios($nome = 'user_id') //TODO Ajustar combo
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

    public function ArrayComboUsuarios($nomes = ['user_id']) //TODO Ajustar combo
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