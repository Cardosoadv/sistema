<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tarefas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tarefa'        => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'tarefa'           => ['type' => 'varchar', 'constraint' => 150],
            'prazo'            => ['type' => 'datetime', 'null' => true],
            'prioridade'       => ['type' => 'varchar', 'constraint' => 150],
            'detalhes'         => ['type' => 'text','null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_tarefa');
        $this->forge->createTable('tarefas');
    }
    

    public function down()
    {
        $this->forge->dropTable('tarefas');
    }
}
