<?php

namespace App\Libraries;



class Debug{

        //função para formatar a data. Ainda não foi testada.
        public function debug($data)
        {
                        echo '<pre>';
                        print_r($data);
                        echo '</pre>';
        }
    
}