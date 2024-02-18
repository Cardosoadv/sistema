<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Menus extends Seeder
{
    public function run()
    {
        //cria o menu pessoas
        $pessoas = [
            'menu'=>'Pessoas',
            'icone'=>'bi-person-gear',
        ];
        
        $this->db->table('sys_menu')->insert($pessoas);
        $pessoas_id = $this->db->insertID();
        
        //cria o menu financeiro
        $financeiro = [
            'menu'=>'Financeiro',
            'icone'=>'bi-cash-coin',
        ];
        
        $this->db->table('sys_menu')->insert($financeiro);
        $financeiro_id = $this->db->insertID();

        //cria o submenu de vendas no menu financeiro
        $vendas = [
            'submenu'=>'Vendas',
            'icone' => 'bi-box-arrow-in-down',
            'link'=> 'revenues',
            'menu_pai'=> $financeiro_id,
        ];
        $this->db->table('sys_submenu')->insert($vendas);

        //cria o submenu de despesas no menu financeiro
        $despesas = [
            'submenu'=>'Despesas',
            'icone' => 'bi-box-arrow-up',
            'link'=> 'expenses',
            'menu_pai'=> $financeiro_id,
        ];
        $this->db->table('sys_submenu')->insert($despesas);

        //cria o submenu clientes no menu pessoas
        $clientes = [
            'submenu'=>'Clientes',
            'icone' => 'bi-people',
            'link'=> 'clients',
            'menu_pai'=> $pessoas_id,
        ];
        $this->db->table('sys_submenu')->insert($clientes);
    }
}