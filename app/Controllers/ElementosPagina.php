<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ClientsModel;
use DateTime;

class ElementosPagina extends BaseController
{

public function comboClientes($nome = 'cliente_id')
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


}