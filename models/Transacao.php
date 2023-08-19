<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banco.transacao".
 *
 * @property int $id
 * @property int $tipo
 * @property int $data_hora
 * @property float $valor
 * @property int $conta_origem_numero
 * @property int $conta_destino_numero
 */
class Transacao extends \yii\db\ActiveRecord
{
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
            [['tipo', 'data_hora', 'valor', 'conta_origem_numero', 'conta_destino_numero'], 'required'],
            [['tipo', 'data_hora', 'conta_origem_numero', 'conta_destino_numero'], 'default', 'value' => null],
            [['tipo', 'data_hora', 'conta_origem_numero', 'conta_destino_numero'], 'integer'],
            [['valor'], 'number'],
            [['conta_origem_numero'], 'exist', 'skipOnError' => true, 'targetClass' => Conta::class, 'targetAttribute' => ['conta_origem_numero' => 'numero']],
            [['conta_destino_numero'], 'exist', 'skipOnError' => true, 'targetClass' => Conta::class, 'targetAttribute' => ['conta_destino_numero' => 'numero']],
            [['tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoTransacao::class, 'targetAttribute' => ['tipo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'data_hora' => 'Data Hora',
            'valor' => 'Valor',
            'conta_origem_numero' => 'Conta Origem Numero',
            'conta_destino_numero' => 'Conta Destino Numero',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('arquivos/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
