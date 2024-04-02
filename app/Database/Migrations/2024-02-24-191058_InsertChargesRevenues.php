<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertChargesRevenues extends Migration
{
    public function up()
    {
/*        $fields = [
        'late_fee'       => ['type' => 'double', 'null' => true, 'after'=>'comments'],
        'interest'       => ['type' => 'double', 'null' => true, 'after'=>'late_fee'],
        'charges'        => ['type' => 'double', 'null' => true, 'after'=>'charges'],
        ];
        $this->forge->addColumn('revenues', $fields);
*/
        $newFields = [
            'user1'          => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'account_id'],
            'user2'          => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'user1'],
            'user3'          => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'user2'],
            'user4'          => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'user3'],
            'user5'          => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'user4'],
            'user6'          => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'user5'],
            'share_user1'    => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'user6'],
            'share_user2'    => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'share_user1'],
            'share_user3'    => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'share_user2'],
            'share_user4'    => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'share_user3'],
            'share_user5'    => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'share_user4'],
            'share_user6'    => ['type' => 'int', 'constraint' => 11, 'null' => true,'after'=>'share_user5'],
            'late_fee'       => ['type' => 'double', 'null' => true, 'after'=>'comments'],
            'interest'       => ['type' => 'double', 'null' => true, 'after'=>'late_fee'],
            'charges'        => ['type' => 'double', 'null' => true, 'after'=>'interest'],
            ];
            $this->forge->addColumn('expenses', $newFields);
    }

    public function down()
    {
        //
    }
}
