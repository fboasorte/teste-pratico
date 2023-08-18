<?php

use yii\db\Migration;

/**
 * Class m230818_190915_cria_tabelas
 */
class m230818_190915_cria_tabelas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE SCHEMA banco AUTHORIZATION aluno;');

        $this->execute("
        CREATE TABLE banco.cliente (
            id              serial PRIMARY KEY,
            nome            TEXT NOT NULL,
            cpf             CHAR(11) NOT NULL,
            endereco        TEXT,
            nascimento      date,
            telefone        INTEGER
        );
        ");

        $this->execute("
        CREATE TABLE banco.tipo_conta (
            id              serial PRIMARY KEY,
            nome            TEXT NOT NULL
        );
        ");

        $this->execute("
        CREATE TABLE banco.tipo_transacao (
            id              serial PRIMARY KEY,
            nome            TEXT NOT NULL
        );
        ");

        $this->execute("
        CREATE TABLE banco.conta (
            numero              serial PRIMARY KEY,
            tipo                INTEGER REFERENCES banco.tipo_conta(id) NOT NULL,
            saldo               DECIMAL NOT NULL,
            cliente_id          INTEGER REFERENCES banco.cliente(id) NOT NULL
        );
        ");

        $this->execute("
        CREATE TABLE banco.transacao (
            id                  serial PRIMARY KEY,
            tipo                INTEGER REFERENCES banco.tipo_transacao(id) NOT NULL,
            data_hora           INTEGER NOT NULL,
            valor               DECIMAL NOT NULL,
            conta_origem_numero        INTEGER REFERENCES banco.conta(numero) NOT NULL,
            conta_destino_numero       INTEGER REFERENCES banco.conta(numero) NOT NULL
        );
        ");
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP TABLE banco.transacao;");
        $this->execute("DROP TABLE banco.tipo_transacao;");
        $this->execute("DROP TABLE banco.conta;");
        $this->execute("DROP TABLE banco.tipo_conta;");
        $this->execute("DROP TABLE banco.cliente;");
        $this->execute("DROP SCHEMA banco;");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230818_190915_cria_tabelas cannot be reverted.\n";

        return false;
    }
    */
}
