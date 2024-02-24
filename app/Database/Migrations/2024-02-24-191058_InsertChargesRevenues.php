<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertChargesRevenues extends Migration
{
    public function up()
    {
        $fields = [
        'late_fee'       => ['type' => 'double', 'null' => true, 'after'=>'comments'],
        'interest'       => ['type' => 'double', 'null' => true, 'after'=>'late_fee'],
        'charges'        => ['type' => 'double', 'null' => true, 'after'=>'charges'],
        ];
        $this->forge->addColumn('revenues', $fields);

        $newFields = [
            'late_fee'       => ['type' => 'double', 'null' => true, 'after'=>'comments'],
            'interest'       => ['type' => 'double', 'null' => true, 'after'=>'late_fee'],
            'charges'        => ['type' => 'double', 'null' => true, 'after'=>'charges'],
            ];
            $this->forge->addColumn('expenses', $newFields);
    }

    public function down()
    {
        //
    }
}
