<?php

use yii\db\Migration;

/**
 * Class m230819_180707_cria_permissoes
 */
class m230819_180707_cria_permissoes extends Migration
{
    public $data;

    public $rotas_tipo_conta = [
        'tipo-conta/index',
        'tipo-conta/update',
        'tipo-conta/create',
        'tipo-conta/view',
    ];

    public $rotas_tipo_transacao = [
        'tipo-transacao/index',
        'tipo-transacao/update',
        'tipo-transacao/create',
        'tipo-transacao/view',
    ];

    public $rotas_conta = [
        'conta/index',
        'conta/update',
        'conta/create',
        'conta/view',
    ];

    public $rotas_cliente = [
        'cliente/index',
        'cliente/update',
        'cliente/create',
        'cliente/view',
    ];

    public $rotas_transacao = [
        'transacao/index',
        'transacao/update',
        'transacao/create',
        'transacao/view',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->execute("
        CREATE TABLE public.auth_rule (
            name          TEXT PRIMARY KEY,
            data          TEXT NOT NULL
        );
        ");

        $this->execute("
        CREATE TABLE public.auth_item (
            name            TEXT PRIMARY KEY,
            type            INTEGER NOT NULL,
            description     TEXT,
            rule_name       TEXT REFERENCES public.auth_rule(name),
            data            TEXT,
            created_at      INTEGER,
            updated_at       INTEGER
        );
        ");

        $this->execute("
        CREATE TABLE public.auth_item_child (
            parent          TEXT REFERENCES public.auth_item(name) NOT NULL,
            child           TEXT REFERENCES public.auth_item(name) NOT NULL
        );
        ");

        $this->addPrimaryKey('auth_item_child_pkey', 'public.auth_item_child', ['parent', 'child']);

        $this->execute("
        CREATE TABLE public.auth_assignment (
            item_name         TEXT REFERENCES public.auth_item(name) NOT NULL,
            user_id           INTEGER NOT NULL,
            created_at      INTEGER,
            updated_at       INTEGER
        );
        ");

        /*Papel*/
        $this->insert('auth_item', [
            'name' => 'admin',
            'type' => 1,
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_item', [
            'name' => 'demo',
            'type' => 1,
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        /*Permissão*/
        $this->insert('auth_item', [
            'name' => 'gestorTipoConta',
            'type' => 2,
            'description' => 'Permissão de leitura e escrita',
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_item', [
            'name' => 'gestorCliente',
            'type' => 2,
            'description' => 'Permissão de leitura e escrita',
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_item', [
            'name' => 'gestorTipoTransacao',
            'type' => 2,
            'description' => 'Permissão de leitura e escrita',
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_item', [
            'name' => 'gestorConta',
            'type' => 2,
            'description' => 'Permissão de leitura e escrita',
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_item', [
            'name' => 'gestorTransacao',
            'type' => 2,
            'description' => 'Permissão de leitura e escrita',
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        foreach ($this->rotas_tipo_conta as $rota) {
            $this->insert('auth_item', ['name' => $rota, 'type' => 2, 'description' => 'Rota',
                'created_at' => $this->data, 'updated_at' => $this->data]);
        }

        foreach ($this->rotas_tipo_transacao as $rota) {
            $this->insert('auth_item', ['name' => $rota, 'type' => 2, 'description' => 'Rota',
                'created_at' => $this->data, 'updated_at' => $this->data]);
        }

        foreach ($this->rotas_cliente as $rota) {
            $this->insert('auth_item', ['name' => $rota, 'type' => 2, 'description' => 'Rota',
                'created_at' => $this->data, 'updated_at' => $this->data]);
        }

        foreach ($this->rotas_conta as $rota) {
            $this->insert('auth_item', ['name' => $rota, 'type' => 2, 'description' => 'Rota',
                'created_at' => $this->data, 'updated_at' => $this->data]);
        }

        foreach ($this->rotas_transacao as $rota) {
            $this->insert('auth_item', ['name' => $rota, 'type' => 2, 'description' => 'Rota',
                'created_at' => $this->data, 'updated_at' => $this->data]);
        }

        /*Assign*/
        $this->insert('auth_assignment', [
            'item_name' => 'demo',
            'user_id' => 101,
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_assignment', [
            'item_name' => 'admin',
            'user_id' => 100,
            'created_at' => $this->data,
            'updated_at' => $this->data
        ]);

        $this->insert('auth_item_child', ['parent' => 'admin', 'child' => 'demo']);

        $this->insert('auth_item_child', ['parent' => 'admin', 'child' => 'gestorTipoConta']);

        $this->insert('auth_item_child', ['parent' => 'admin', 'child' => 'gestorTipoTransacao']);

        $this->insert('auth_item_child', ['parent' => 'demo', 'child' => 'gestorCliente']);

        $this->insert('auth_item_child', ['parent' => 'demo', 'child' => 'gestorConta']);

        $this->insert('auth_item_child', ['parent' => 'demo', 'child' => 'gestorTransacao']);

        foreach ($this->rotas_tipo_conta as $rota) {
            $this->batchInsert('auth_item_child', ['parent', 'child'], [
            ['gestorTipoConta', $rota],]);
        }

        foreach ($this->rotas_tipo_transacao as $rota) {
            $this->batchInsert('auth_item_child', ['parent', 'child'], [
            ['gestorTipoTransacao', $rota],]);
        }

        foreach ($this->rotas_cliente as $rota) {
            $this->batchInsert('auth_item_child', ['parent', 'child'], [
            ['gestorCliente', $rota],]);
        }

        foreach ($this->rotas_conta as $rota) {
            $this->batchInsert('auth_item_child', ['parent', 'child'], [
            ['gestorConta', $rota],]);
        }

        foreach ($this->rotas_transacao as $rota) {
            $this->batchInsert('auth_item_child', ['parent', 'child'], [
            ['gestorTransacao', $rota],]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP TABLE public.auth_assignment;");
        $this->execute("DROP TABLE public.auth_item_child;");
        $this->execute("DROP TABLE public.auth_item;");
        $this->execute("DROP TABLE public.auth_rule;");

        return true;
    }
}
