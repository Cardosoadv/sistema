<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'menu'           => ['type' => 'varchar', 'constraint' => 30],
            'icone'          => ['type' => 'varchar', 'constraint' => 30],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sys_menu');

        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'submenu'        => ['type' => 'varchar', 'constraint' => 30],
            'link'           => ['type' => 'varchar', 'constraint' => 100],
            'icone'          => ['type' => 'varchar', 'constraint' => 30],
            'menu_pai'       => ['type' => 'int', 'constraint' => 11],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sys_submenu');
    }

    public function down()
    {
        //
    }
}
