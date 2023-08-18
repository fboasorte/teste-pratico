<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banco.conta".
 *
 * @property int $numero
 * @property int $tipo
 * @property float $saldo
 * @property int $cliente_id
 */
class Conta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banco.conta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'saldo', 'cliente_id'], 'required'],
            [['tipo', 'cliente_id'], 'default', 'value' => null],
            [['tipo', 'cliente_id'], 'integer'],
            [['saldo'], 'number'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => BancoCliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => BancoTipoConta::class, 'targetAttribute' => ['tipo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'tipo' => 'Tipo',
            'saldo' => 'Saldo',
            'cliente_id' => 'Cliente ID',
        ];
    }
}
