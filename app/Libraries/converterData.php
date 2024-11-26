<?php

namespace App\Libraries;

use DateTime;


class ConveterData{

        //função para formatar a data. Ainda não foi testada.
        public function novaData($data)
        {
        $novaData = date_format(new DateTime($data), 'Y-m-d');
        return $novaData;
        }
    
}