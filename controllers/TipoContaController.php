<?php

namespace app\controllers;

use Yii;
use app\models\TipoConta;
use app\models\TipoContaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoContaController implements the CRUD actions for TipoConta model.
 */
class TipoContaController extends Controller
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
     * Lists all TipoConta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('gestorTipoConta')) {
            $searchModel = new TipoContaSearch();
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
     * Displays a single TipoConta model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('gestorTipoConta')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Creates a new TipoConta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('gestorTipoConta')) {
            $model = new TipoConta();

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
     * Updates an existing TipoConta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('gestorTipoConta')) {
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
     * Deletes an existing TipoConta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('gestorTipoConta')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Finds the TipoConta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TipoConta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoConta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
