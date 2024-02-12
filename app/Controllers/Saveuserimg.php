<?php

namespace App\Controllers;

use App\Models\UserImgModel;


class Saveuserimg extends BaseController
{
    public function index()
    {
        $img = $this->request->getFile('foto-perfil');
        $user_id=$this->request->getVar('id');
        $newName = $img->getClientName();
        if ($img->isValid()){
            $img->move(WRITEPATH . 'uploads/user/'.$user_id.'/', null, true);
                $data = [
                'img' => $newName,
                'user_id' => $user_id
                ];
        $userimgModel = new UserImgModel();
        $userimgModel->insert($data);
        };
        return redirect()->to(previous_url());
    }
}
