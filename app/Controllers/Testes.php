<?php

namespace App\Controllers;


use App\Models\UserImgModel;


class Testes extends BaseController
{
    public function index(): string
    {
        $userimgmodel = new UserImgModel();
        $img = $userimgmodel->where('user_id', user_id())->first();
        if (!$img['img']==NULL){
        $url = 'img/exibir/'.$img['img'];
        }else{
        $url = 'public/dist/assets/img/user1-128x128.jpg';
        }
       return $url;
    }

}

