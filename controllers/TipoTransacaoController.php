<?php

namespace app\controllers;

use Yii;
use app\models\TipoTransacao;
use app\models\TipoTransacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoTransacaoController implements the CRUD actions for TipoTransacao model.
 */
class TipoTransacaoController extends Controller
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
     * Lists all TipoTransacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('gestorTipoTransacao')) {
            $searchModel = new TipoTransacaoSearch();
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
     * Displays a single TipoTransacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('gestorTipoTransacao')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Creates a new TipoTransacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('gestorTipoTransacao')) {
            $model = new TipoTransacao();

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Cadastro realizado com sucesso');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Updates an existing TipoTransacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('gestorTipoTransacao')) {
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
     * Deletes an existing TipoTransacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('gestorTipoTransacao')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Finds the TipoTransacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TipoTransacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoTransacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
