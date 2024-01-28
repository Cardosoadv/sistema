<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Finances extends Migration
{
    public function up()
    {
        // Create client table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'varchar', 'constraint' => 100],
            'email'          => ['type' => 'varchar', 'constraint' => 100],
            'celular'        => ['type' => 'varchar', 'constraint' => 20],
            'landed_at'      => ['type' => 'date'],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('clients');

        // Create expenses table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'expense'        => ['type' => 'varchar', 'constraint' => 150],
            'due_dt'         => ['type' => 'date', 'null' => true],
            'value'          => ['type' => 'double', 'null' => true],
            'category'       => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'reconciled'     => ['type' => 'boolean', 'default' => FALSE],
            'client_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'account_id'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'share'          => ['type' => 'int', 'constraint' => 11, 'null' => true],            
            'comments'       => ['type' => 'text','null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('expenses');

        // Create revenues table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'revenues'       => ['type' => 'varchar', 'constraint' => 150],
            'due_dt'         => ['type' => 'date', 'null' => true],
            'value'          => ['type' => 'double', 'null' => true],
            'category'       => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'client_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'account_id'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'share'          => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'reconciled'     => ['type' => 'boolean', 'default' => FALSE],
            'comments'       => ['type' => 'text','null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('revenues');

        // Create accounts table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'account'        => ['type' => 'varchar', 'constraint' => 150],
            'comments'       => ['type' => 'text','null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('accounts');

        // Create share table
        $this->forge->addField([
            'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'share'          => ['type' => 'varchar', 'constraint' => 200],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('share');


    }

    public function down()
    {
        //
    }
}
