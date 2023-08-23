<?php

namespace app\controllers;

use app\models\Transacao;
use app\models\TransacaoSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use DateTime;
use Exception;
use lib\behaviors\AccessControl;

// TODO: 
// - Salvar o nome do arquivo como hash
// - Permitir editar o arquivo no alterar transacao
// - Tratar os diferentes tipos de transacao(deposito, transferencia, saque)

/**
 * TransacaoController implements the CRUD actions for Transacao model.
 */
class TransacaoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                ],
            ]
        );
    }

    /**
     * Lists all Transacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransacaoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Transacao();

        if ($model->load(Yii::$app->request->post())) {
            $objetoData = new DateTime;
            $model->data_hora = (int) $objetoData->getTimestamp();

            if (!$model->temOrigemEDestinoDiferentes()) {
                Yii::$app->session->setFlash('danger', 'Conta de Origem e destinos não podem ser iguais');
                return $this->redirect(['create']);
            }

            if (!$model->podeSerRealizada()) {
                Yii::$app->session->setFlash('danger', 'A conta não tem saldo suficiente');
                return $this->redirect(['create']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->arquivo = UploadedFile::getInstance($model, 'comprovante');
                $hashArquivo = $model->gerarHash();
                if ($model->upload($hashArquivo)) {
                    $model->comprovante = $hashArquivo . '.' . $model->arquivo->extension;

                    if ($model->save() && $model->transfereValor()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Cadastro realizado com sucesso');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', Yii::t('app', $ex->getMessage()));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Atualização realizada com sucesso');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Transacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Registro excluido com sucesso');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Transacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
