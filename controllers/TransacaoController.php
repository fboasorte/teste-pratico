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
        if (Yii::$app->user->can('gestorTransacao')) {
            $searchModel = new TransacaoSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Displays a single Transacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('gestorTransacao')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Creates a new Transacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('gestorTransacao')) {
            $model = new Transacao();

            if ($model->load(Yii::$app->request->post())) {
                $objetoData = new DateTime;
                $model->data_hora = (int) $objetoData->getTimestamp();
                try {

                    $model->arquivo = UploadedFile::getInstance($model, 'comprovante');
                    $model->upload();
                    $model->comprovante = $model->arquivo->baseName . '.' . $model->arquivo->extension;

                    if (!$model->save()) {
                        throw new \Exception(implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
                    }

                    Yii::$app->session->setFlash('success', 'Cadastro realizado com sucesso');
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (\Exception $ex) {
                    Yii::$app->session->setFlash('error', Yii::t('app', $ex->getMessage()));
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['error']);
        }
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
        if (Yii::$app->user->can('gestorTransacao')) {
            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Atualização realizada com sucesso');
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['error']);
        }
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
        if (Yii::$app->user->can('gestorTransacao')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            return $this->redirect(['error']);
        }
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
