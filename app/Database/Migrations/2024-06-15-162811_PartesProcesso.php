<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PartesProcesso extends Migration
{
    public function up()
    {
        /**
         * Cria Tabela de Anotações de Processos
         */
        $this->forge->addField([
            'id_parte'         => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'pessoa_id'        => ['type' => 'int', 'constraint' => 11],
            'qualificacao'     => ['type' => 'varchar', 'constraint' => 150],
            'processo_id'      => ['type' => 'int', 'constraint' => 11],
            'e_cliente'        => ['type' => 'tinyint'],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_parte');
        $this->forge->addForeignKey('pessoa_id', 'pessoas', 'id_pessoa', '', 'CASCADE', 'parteProcessos_Pessoas');
        $this->forge->createTable('processos_partes');
    }

    public function down()
    {
        $this->forge->dropForeignKey('processos_partes', 'parteProcessos_Pessoas');
        $this->forge->dropTable('processos_partes');
    }
}
