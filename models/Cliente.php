<?php

namespace app\models;

use Yii;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "banco.cliente".
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string|null $endereco
 * @property string|null $nascimento
 * @property int|null $telefone
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banco.cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'cpf'], 'required'],
            [['nome', 'endereco'], 'string'],
            [['nascimento'], 'safe'],
            [['telefone'], 'default', 'value' => null],
            [['telefone'], 'string', 'max' => 11],
            [['cpf'], 'string', 'max' => 11],
            [['cpf'], CpfValidator::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'cpf' => Yii::t('app', 'CPF'),
            'endereco' => Yii::t('app', 'Endereço'),
            'nascimento' => Yii::t('app', 'Nascimento'),
            'telefone' => Yii::t('app', 'Telefone'),
        ];
    }
}
