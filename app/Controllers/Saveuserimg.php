<?php

namespace App\Controllers;

use App\Models\UserImgModel;
use CodeIgniter\Files\File;

class Saveuserimg extends BaseController
{
    public function index()
    {
        $img = $this->request->getFile('foto-perfil');
        $data['user_id']=$this->request->getVar('id');

        if (! $img->hasMoved()) {
            $filepath = WRITEPATH . 'uploads/' . $img->store();
            $data = ['img' => new File($filepath)];
        $userimgModel = new UserImgModel();
        $userimgModel->insert($data);
        return redirect()->to(current_url());

        }

    }
}
