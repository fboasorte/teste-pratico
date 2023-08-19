<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banco.conta".
 *
 * @property int $numero
 * @property int $tipo_conta_id
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
            [['tipo_conta_id', 'saldo', 'cliente_id'], 'required'],
            [['tipo_conta_id', 'cliente_id'], 'default', 'value' => null],
            [['tipo_conta_id', 'cliente_id'], 'integer'],
            [['saldo'], 'number'],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['tipo_conta_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoConta::class, 'targetAttribute' => ['tipo_conta_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Número',
            'tipo_conta_id' => 'Tipo de Conta',
            'saldo' => 'Saldo',
            'cliente_id' => 'Dono da Conta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoConta()
    {
        return $this->hasOne(TipoConta::class, ['id' => 'tipo_conta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }
}
