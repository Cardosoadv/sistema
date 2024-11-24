<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tratamento extends Migration
{
    public function up()
    {
        $fields = [
            'statusTratamento'  =>  ['type' => 'tinyint', 'after' => 'numeroprocessocommascara']

        ];
        $this->forge->addColumn('intimacoes', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('intimacoes', 'statusTratamento');
    }
}
