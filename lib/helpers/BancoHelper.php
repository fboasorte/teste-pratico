<?php

namespace lib\helpers;

use yii\db\Query;

abstract class BancoHelper
{

    /**
     * @return array Relação de todos os tipos de contas(id, nome).
     */
    public static function tipoContas()
    {
        $sql = (new Query())->select(['tipo_conta_id' => 'id', 'nome' => 'nome'])
            ->from('banco.tipo_conta')->all();
        return $sql;
    }

    /**
     * @return array Relação de todos os clientes(id, nome).
     */
    public static function clientes()
    {
        $sql = (new Query())->select(['cliente_id' => 'id', 'nome' => 'nome'])
            ->from('banco.cliente')->all();
        return $sql;
    }

    /**
     * @return array Relação de todos os clientes(id, nome).
     */
    public static function tipoTransacoes()
    {
        $sql = (new Query())->select(['tipo_transacao_id' => 'id', 'nome' => 'nome'])
            ->from('banco.tipo_transacao')->all();
        return $sql;
    }

    /**
     * @return array Relação de todos as contas(numero, nome).
     */
    public static function contas()
    {
        $sql = (new Query())->select(['conta_numero' => 'numero', 'nome' => 'nome'])
            ->from('banco.conta')->join('inner join', 'banco.cliente', 'cliente_id = id')->all();
        return $sql;
    }
}
