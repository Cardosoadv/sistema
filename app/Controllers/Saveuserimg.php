<?php

namespace App\Controllers;

use App\Models\UserImgModel;

class Saveuserimg extends BaseController
{
    public function index($id)
    {
        $data['img'] = $this->request->getFile('foto-perfil');
        $data['user_id']=$id;
        $userimgModel = new UserImgModel();
        $userimgModel->insert($data);
        return redirect('Home::index');
    }
}
