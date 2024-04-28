<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Start extends Migration
{
    public function up()
    {
        /**
         * Menus do sistema
         */
        $this->forge->addField([
            'id_menu'        => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'menu'           => ['type' => 'varchar', 'constraint' => 30],
            'icone'          => ['type' => 'varchar', 'constraint' => 30],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_menu');
        $this->forge->createTable('sys_menu');

        $this->forge->addField([
            'id_submenu'     => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'submenu'        => ['type' => 'varchar', 'constraint' => 30],
            'link'           => ['type' => 'varchar', 'constraint' => 100],
            'icone'          => ['type' => 'varchar', 'constraint' => 30],
            'menu_pai'       => ['type' => 'int', 'constraint' => 11],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_submenu');
        $this->forge->addForeignKey('menu_pai', 'sys_menu', 'id_menu', '', 'CASCADE');
        $this->forge->createTable('sys_submenu');

        /**
         * Cria tabela de imagem do usuário
         */
        $this->forge->addField([
            'id_auth_img'    => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'img'            => ['type' => 'varchar', 'constraint' => 100],
            'user_id'        => ['type' => 'int','constraint' => 11],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_auth_img');
        $this->forge->createTable('auth_user_img');

        /**
         * Cria tabela de Pessoas
         */
        $this->forge->addField([
            'id_pessoa'      => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'nome'           => ['type' => 'varchar', 'constraint' => 100],
            'email'          => ['type' => 'varchar', 'constraint' => 100],
            'celular'        => ['type' => 'varchar', 'constraint' => 20],
            'cpf_cnpj'       => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'logradouro'     => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'numero'         => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'complemento'    => ['type' => 'varchar', 'constraint' => 45,'null' => true],
            'bairro'         => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'cidade'         => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'estado'         => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'cep'            => ['type' => 'varchar', 'constraint' => 200,'null' => true],
            'aquisicao_dt'   => ['type' => 'date', 'null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_pessoa');
        $this->forge->createTable('pessoas');

        /**
         * Cria tabela tipo de pessoa
         */
        $this->forge->addField([
            'pessoa_id'          => ['type' => 'int','constraint' => 11],
            'tipo_pessoa'        => ['type' => 'varchar', 'constraint' => 100],
        ]);
        $this->forge->addForeignKey('pessoa_id', 'pessoas', 'id_pessoa', '', 'CASCADE');
        $this->forge->createTable('tipo_pessoa');

        /**
         * Cria tabela de contas bancárias
         */
        $this->forge->addField([
            'id_conta'        => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'conta'           => ['type' => 'varchar', 'constraint' => 150],
            'comentario'      => ['type' => 'text','null' => true],
            'created_at'      => ['type' => 'datetime', 'null' => true],
            'updated_at'      => ['type' => 'datetime', 'null' => true],
            'deleted_at'      => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_conta');
        $this->forge->createTable('contas');

        /**
         * Cria Tabela de Categorias
         */
        $this->forge->addField([
            'id_categoria'     => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'categoria'        => ['type' => 'varchar', 'constraint' => 150],
            'comentario'       => ['type' => 'text','null' => true],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_categoria');
        $this->forge->createTable('categorias');

        /**
         * Cria tabela de despesas
         */
        $this->forge->addField([
            'id_despesa'     => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'despesa'        => ['type' => 'varchar', 'constraint' => 150],
            'vencimento_dt'  => ['type' => 'date', 'null' => true],
            'valor'          => ['type' => 'double', 'null' => true],
            'categoria'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'conciliado'     => ['type' => 'boolean', 'default' => FALSE],
            'pessoa_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],     
            'comentario'     => ['type' => 'text','null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_despesa');
        $this->forge->addForeignKey('pessoa_id', 'pessoas', 'id_pessoa', '', 'CASCADE');
        $this->forge->addForeignKey('categoria', 'categorias', 'id_categoria', '', 'CASCADE');
        $this->forge->createTable('despesas');

        /**
        * Cria tabela de Vendas
        */
        $this->forge->addField([
            'id_venda'       => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'venda'          => ['type' => 'varchar', 'constraint' => 150],
            'vencimento_dt'  => ['type' => 'date', 'null' => true],
            'valor'          => ['type' => 'double', 'null' => true],
            'categoria'      => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'conciliado'     => ['type' => 'boolean', 'default' => FALSE],
            'pessoa_id'      => ['type' => 'int', 'constraint' => 11, 'null' => true],     
            'comentario'     => ['type' => 'text','null' => true],
            'created_at'     => ['type' => 'datetime', 'null' => true],
            'updated_at'     => ['type' => 'datetime', 'null' => true],
            'deleted_at'     => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_venda');
        $this->forge->addForeignKey('pessoa_id', 'pessoas', 'id_pessoa', '', 'CASCADE');
        $this->forge->addForeignKey('categoria', 'categorias', 'id_categoria', '', 'CASCADE');
        $this->forge->createTable('vendas');

        /**
         * Cria a Tabela de Pagamentos
         */
        $this->forge->addField([
            'id_pagamento'        => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'despesa_id'          => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'pagamento_dt'        => ['type' => 'date', 'null' => true],
            'valor'               => ['type' => 'double', 'null' => true],
            'multa'               => ['type' => 'double', 'null' => true],
            'juros'               => ['type' => 'double', 'null' => true],
            'encargos'            => ['type' => 'double', 'null' => true],
            'conta_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'conciliado'          => ['type' => 'boolean', 'default' => FALSE],
            'comentario'          => ['type' => 'text','null' => true],
            'created_at'          => ['type' => 'datetime', 'null' => true],
            'updated_at'          => ['type' => 'datetime', 'null' => true],
            'deleted_at'          => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_pagamento');
        $this->forge->addForeignKey('despesa_id', 'despesas', 'id_despesa', '', 'CASCADE');
        $this->forge->addForeignKey('conta_id', 'contas', 'id_conta', '', 'CASCADE');
        $this->forge->createTable('pagamentos');

        /**
         * Cria a Tabela de Receitas
         */
        $this->forge->addField([
            'id_receita'          => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'venda_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'pagamento_dt'        => ['type' => 'date', 'null' => true],
            'valor'               => ['type' => 'double', 'null' => true],
            'multa'               => ['type' => 'double', 'null' => true],
            'juros'               => ['type' => 'double', 'null' => true],
            'encargos'            => ['type' => 'double', 'null' => true],
            'conta_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'conciliado'          => ['type' => 'boolean', 'default' => FALSE],
            'comentario'          => ['type' => 'text','null' => true],
            'created_at'          => ['type' => 'datetime', 'null' => true],
            'updated_at'          => ['type' => 'datetime', 'null' => true],
            'deleted_at'          => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_receita');
        $this->forge->addForeignKey('venda_id', 'vendas', 'id_venda', '', 'CASCADE');
        $this->forge->addForeignKey('conta_id', 'contas', 'id_conta', '', 'CASCADE');
        $this->forge->createTable('receitas');


    }

    public function down()
    {
       $this->forge->dropTable('sys_menu', false, true);
       $this->forge->dropTable('sys_submenu', false, true);
       $this->forge->dropTable('auth_user_img', false, true);
       $this->forge->dropTable('pessoas', false, true);
       $this->forge->dropTable('tipo_pessoa', false, true);
       $this->forge->dropTable('contas', false, true);
       $this->forge->dropTable('categorias', false, true);
       $this->forge->dropTable('despesas', false, true);
       $this->forge->dropTable('vendas', false, true);
       $this->forge->dropTable('pagamentos', false, true);
       $this->forge->dropTable('receitas', false, true);
    }
}
