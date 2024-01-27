<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usersimg extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'img'            => ['type' => 'blob'],
            'user_id'        => ['type' => 'int','constraint' => 11],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('auth_user_img');
    }

    public function down()
    {
        //
    }
}
