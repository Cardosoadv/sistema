<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentsandReceipts extends Migration
{
    public function up()
    {
              // Create receipt_revenues table
              $this->forge->addField([
                'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'revenues_id'    => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'receipt_dt'     => ['type' => 'date', 'null' => true],
                'value'          => ['type' => 'double', 'null' => true],
                'late_fee'       => ['type' => 'double', 'null' => true],
                'interest'       => ['type' => 'double', 'null' => true],
                'charges'        => ['type' => 'double', 'null' => true],
                'account_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user1'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user2'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user3'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user4'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user5'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user6'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'share_user1'     => ['type' => 'double', 'null' => true],
                'share_user2'     => ['type' => 'double', 'null' => true],
                'share_user3'     => ['type' => 'double', 'null' => true],
                'share_user4'     => ['type' => 'double', 'null' => true],
                'share_user5'     => ['type' => 'double', 'null' => true],
                'share_user6'     => ['type' => 'double', 'null' => true],
                'reconciled'     => ['type' => 'boolean', 'default' => FALSE],
                'comments'       => ['type' => 'text','null' => true],
                'created_at'     => ['type' => 'datetime', 'null' => true],
                'updated_at'     => ['type' => 'datetime', 'null' => true],
                'deleted_at'     => ['type' => 'datetime', 'null' => true],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('receipts_revenues');

            // Create payments_expenses table
            $this->forge->addField([
                'id'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'expenses_id'    => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'payment_dt'     => ['type' => 'date', 'null' => true],
                'value'          => ['type' => 'double', 'null' => true],
                'late_fee'       => ['type' => 'double', 'null' => true],
                'interest'       => ['type' => 'double', 'null' => true],
                'charges'        => ['type' => 'double', 'null' => true],
                'account_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user1'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user2'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user3'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user4'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user5'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'user6'     => ['type' => 'int', 'constraint' => 11, 'null' => true],
                'share_user1'     => ['type' => 'double', 'null' => true],
                'share_user2'     => ['type' => 'double', 'null' => true],
                'share_user3'     => ['type' => 'double', 'null' => true],
                'share_user4'     => ['type' => 'double', 'null' => true],
                'share_user5'     => ['type' => 'double', 'null' => true],
                'share_user6'     => ['type' => 'double', 'null' => true],
                'reconciled'     => ['type' => 'boolean', 'default' => FALSE],
                'comments'       => ['type' => 'text','null' => true],
                'created_at'     => ['type' => 'datetime', 'null' => true],
                'updated_at'     => ['type' => 'datetime', 'null' => true],
                'deleted_at'     => ['type' => 'datetime', 'null' => true],
            ]);
            $this->forge->addPrimaryKey('id');
            $this->forge->createTable('payments_expenses');
    }

    public function down()
    {
        //
    }
}
