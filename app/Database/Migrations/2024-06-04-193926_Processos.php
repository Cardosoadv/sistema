<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Processos extends Migration
{
    public function up()
    {
        /**
         * Cria Tabela de Processos
         */
        $this->forge->addField([
            'id_processo'      => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'processo'         => ['type' => 'varchar', 'constraint' => 150],
            'acao'             => ['type' => 'text','null' => true],
            'numero'           => ['type' => 'varchar', 'constraint' => 15],
            'juizo'            => ['type' => 'varchar', 'constraint' => 150],
            'vlr_causa'        => ['type' => 'double', 'null' => true],
            'dt_distribuicao'  => ['type' => 'date', 'null' => true],
            'vlr_condenacao'   => ['type' => 'double', 'null' => true],
            'comentarios'      => ['type' => 'text','null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_processo');
        $this->forge->createTable('processos');

        /**
         * Cria Tabela de Anotações de Processos
         */
        $this->forge->addField([
            'id_anotacao'      => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'titulo'           => ['type' => 'varchar', 'constraint' => 150],
            'anotacao'         => ['type' => 'text','null' => true],
            'privacidade'      => ['type' => 'int', 'constraint' => 15],
            'processo_id'      => ['type' => 'int', 'constraint' => 11],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_anotacao');
        $this->forge->addForeignKey('processo_id', 'processos', 'id_processo', '', 'CASCADE', 'anotacao_processos');
        $this->forge->createTable('processos_anotacao');

    }

    public function down()
    {
        $this->forge->dropForeignKey('anotacao', 'anotacao_processos');
        $this->forge->dropTable('processos');
        $this->forge->dropTable('processos_anotacao');
    }
}
