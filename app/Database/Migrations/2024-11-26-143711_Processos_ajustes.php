<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProcessosAjustes extends Migration
{
    private $Fields =[
            
        'siglaTribunal'             => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
        'nomeOrgao'                 => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
        'numero_processo'           => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
        'tipoDocumento'             => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
        'codigoClasse'              => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
        'ativo'                     => ['type' => 'tinyint'],
        'numeroprocessocommascara'  => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
        ];

    public function up()
    { 
        
        $this->forge->addColumn('processos', $this->Fields);
        

        $this->forge->addField([  

            'id_pk'              => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],    
            'processo_id'       => ['type' => 'int', 'constraint'=>11],
            'advogado_id'       => ['type' => 'int', 'constraint'=>11, 'null' => true],    
            'advogado_nome'     => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'advogado_oab'      => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'advogado_oab_uf'   => ['type' => 'varchar', 'constraint'=>10, 'null' => true],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],

        ]);
        $this->forge->addPrimaryKey('id_pk');
        $this->forge->addForeignKey('processo_id', 'processos', 'id_processo', '', 'CASCADE', 'FK_processos_advogados');
        $this->forge->createTable('processos_advogados');


        $this->forge->addField([
            'id_movimento'              => ['type' => 'int', 'constraint' => 11, 'auto_increment'=>true],
            'processo_id'               => ['type' => 'int', 'constraint'=>11],
            'comunicacao_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'data_disponibilizacao'     => ['type' => 'date', 'null' => true],
            'tipoComunicacao'           => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'texto'                     => ['type' => 'longtext', 'null' => true],
            'meio'                      => ['type' => 'varchar', 'constraint'=>50, 'null' => true],
            'link'                      => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            
            'datadisponibilizacao'      => ['type' => 'date', 'null' => true],
            'dataenvio'                 => ['type' => 'date', 'null' => true],
            'meiocompleto'              => ['type' => 'varchar', 'constraint'=>150, 'null' => true],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_movimento');
        $this->forge->addForeignKey('processo_id', 'processos', 'id_processo', '', 'CASCADE', 'FK_processos_movimento');
        $this->forge->addForeignKey('comunicacao_id', 'intimacoes', 'id_intimacao', '', 'CASCADE', 'FK_intimacoes_movimento');
        $this->forge->createTable('processos_movimento');




    }

    public function down()
    {
        $this->forge->dropForeignKey('processos_movimento', 'FK_intimacoes_movimento');
        $this->forge->dropForeignKey('processos_movimento', 'FK_processos_movimento');
        $this->forge->dropTable('processos_movimento');
        $this->forge->dropTable('processos_advogados');
        $this->forge->dropColumn('processos', $this->Fields);
    }
}
