<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banco.transacao".
 *
 * @property int $id
 * @property int $tipo_transacao_id
 * @property int $data_hora
 * @property float $valor
 * @property int $conta_origem_numero
 * @property int $conta_destino_numero
 */
class Transacao extends \yii\db\ActiveRecord
{
    public $arquivo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banco.transacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_transacao_id', 'data_hora', 'valor', 'conta_origem_numero', 'conta_destino_numero'], 'required'],
            [['tipo_transacao_id', 'data_hora', 'conta_origem_numero', 'conta_destino_numero'], 'default', 'value' => null],
            [['tipo_transacao_id', 'data_hora', 'conta_origem_numero', 'conta_destino_numero'], 'integer'],
            [['valor'], 'number'],
            [['conta_origem_numero'], 'exist', 'skipOnError' => true, 'targetClass' => Conta::class, 'targetAttribute' => ['conta_origem_numero' => 'numero']],
            [['conta_destino_numero'], 'exist', 'skipOnError' => true, 'targetClass' => Conta::class, 'targetAttribute' => ['conta_destino_numero' => 'numero']],
            [['tipo_transacao_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTransacao::class, 'targetAttribute' => ['tipo_transacao_id' => 'id']],
            [['comprovante'], 'file', 'extensions' => 'pdf']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_transacao_id' => 'Tipo',
            'data_hora' => 'Data Hora',
            'valor' => 'Valor',
            'conta_origem_numero' => 'Conta Origem',
            'conta_destino_numero' => 'Conta Destino',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoTransacao()
    {
        return $this->hasOne(TipoTransacao::class, ['id' => 'tipo_transacao_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContaOrigem()
    {
        return $this->hasOne(Conta::class, ['numero' => 'conta_origem_numero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContaDestino()
    {
        return $this->hasOne(Conta::class, ['numero' => 'conta_destino_numero']);
    }

    public function upload($nome)
    {
        if ($this->validate()) {
            $this->arquivo->saveAs(Yii::getAlias('@arquivos') . '/' . $nome . '.' . $this->arquivo->extension);
            return true;
        } else {
            return false;
        }
    }

    public function temOrigemEDestinoDiferentes()
    {
        if ($this->conta_origem_numero != $this->conta_destino_numero) {
            return true;
        }
        return false;
    }

    public function transfereValor()
    {
        $contaOrigem = Conta::findOne(['numero' => $this->conta_origem_numero]);
        $contaDestino = Conta::findOne(['numero' => $this->conta_destino_numero]);

        if (
            $contaOrigem->possuiSaldo($this->valor)
            && $contaOrigem->somaValor(-$this->valor)
            && $contaDestino->somaValor($this->valor)
        ) {
            return true;
        }
        return false;
    }

    public function podeSerRealizada(){
        $contaOrigem = Conta::findOne(['numero' => $this->conta_origem_numero]);
        return $contaOrigem->possuiSaldo($this->valor);
    }

    public function gerarHash(){
        $bytes = random_bytes(15);
        while (file_exists(Yii::getAlias('@arquivos') . bin2hex($bytes)))
            $bytes = random_bytes(15);
        return strtoupper(bin2hex($bytes));
    }
}
