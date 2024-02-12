<?php

namespace App\Controllers;


class Img extends BaseController
{
    public function index(): string
    {
        return view('dashboard');
    }

        public function exibir($img)
    {      
        $file = WRITEPATH . 'uploads/'.$img;
           header('Content-Description: File Transfer');
           header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            return readfile($file);
    }


}
