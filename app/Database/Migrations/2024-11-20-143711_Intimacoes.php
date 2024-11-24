<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Intimacoes extends Migration
{
    public function up()
    { 
        $this->forge->addField([
            'id_intimacao'              => ['type' => 'int', 'constraint' => 11],
            'data_disponibilizacao'     => ['type' => 'date', 'null' => true],
            'siglaTribunal'             => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'tipoComunicacao'           => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'nomeOrgao'                 => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'texto'                     => ['type' => 'longtext', 'null' => true],
            'numero_processo'           => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'meio'                      => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'link'                      => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'tipoDocumento'             => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'codigoClasse'              => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'numeroComunicacao'         => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'ativo'                     => ['type' => 'tinyint'],
            'hash'                      => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'status'                    => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'motivo_cancelamento'       => ['type' => 'varchar', 'constraint'=>250, 'null' => true],
            'data_cancelamento'         => ['type' => 'date', 'null' => true],
            'datadisponibilizacao'      => ['type' => 'date', 'null' => true],
            'dataenvio'                 => ['type' => 'date', 'null' => true],
            'meiocompleto'              => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'numeroprocessocommascara'  => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'               => ['type' => 'datetime', 'null' => true],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_intimacao');
        $this->forge->createTable('intimacoes');

        $this->forge->addField([      
            'id_pk'              => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'nome'               => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'polo'               => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'comunicacao_id'     => ['type' => 'int', 'constraint' => 11],

        ]);
        $this->forge->addPrimaryKey('id_pk');
        $this->forge->addForeignKey('comunicacao_id', 'intimacoes', 'id_intimacao', '', 'CASCADE', 'FK_intimacoes_destinatario');
        $this->forge->createTable('intimacoes_destinatario');


        $this->forge->addField([  
            'id_pk'              => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],    
            'id'                => ['type' => 'int', 'constraint'=>11],
            'comunicacao_id'    => ['type' => 'int', 'constraint'=>11, 'null' => true],
            'advogado_id'       => ['type' => 'int', 'constraint'=>11, 'null' => true],    
            'advogado_nome'     => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'advogado_oab'      => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'advogado_oab_uf'   => ['type' => 'varchar', 'constraint'=>10, 'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],

        ]);
        $this->forge->addPrimaryKey('id_pk');
        $this->forge->addForeignKey('comunicacao_id', 'intimacoes', 'id_intimacao', '', 'CASCADE', 'FK_intimacoes_advogados');
        $this->forge->createTable('intimacoes_advogados');


    }

    public function down()
    {
        $this->forge->dropForeignKey('intimacoes_destinatario', 'FK_intimacoes_destinatario');
        $this->forge->dropForeignKey('intimacoes_advogados', 'FK_intimacoes_advogados');
        $this->forge->dropTable('intimacoes_destinatario');
        $this->forge->dropTable('intimacoes_advogados');
        $this->forge->dropTable('intimacoes');
    }
}
