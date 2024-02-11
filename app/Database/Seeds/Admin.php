<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $userData = [
            'username'=>'admin',
            'active'=>'1',

        ];
        
        $this->db->table('users')->insert($userData);//precisa ajustar inserção parcial e receber user_id
        $user_id = $this->db->insertID();

        $auth_identitiesData = [
            'user_id'=>$user_id,
            'type'=>'email_password',
            'secret'=>'admin@admin.com.br',
            'secret2'=>'$2y$12$80cjaMIa8bX2RzWqclIXNuFX0S8BEvMQTA.qqvvZh8WyurvBpZjBy',
        ];
        $this->db->table('auth_identities')->insert($auth_identitiesData);

        $auth_groups_usersData = [
            'user_id'=>$user_id,
            'group'=>'superadmin'
        ];
        $this->db->table('auth_groups_users')->insert($auth_groups_usersData);
    }
}
