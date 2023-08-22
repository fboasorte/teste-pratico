<?php

namespace app\controllers;

use Yii;
use app\models\Conta;
use app\models\ContaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContaController implements the CRUD actions for Conta model.
 */
class ContaController extends Controller
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
     * Lists all Conta models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('gestorConta')) {
            $searchModel = new ContaSearch();
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
     * Displays a single Conta model.
     * @param int $numero Numero
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($numero)
    {
        if (Yii::$app->user->can('gestorConta')) {
            return $this->render('view', [
                'model' => $this->findModel($numero),
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Creates a new Conta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('gestorConta')) {
            $model = new Conta();

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Cadastro realizado com sucesso');
                    return $this->redirect(['view', 'numero' => $model->numero]);
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
     * Updates an existing Conta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $numero Numero
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($numero)
    {
        if (Yii::$app->user->can('gestorConta')) {
            $model = $this->findModel($numero);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Atualização realizada com sucesso');
                return $this->redirect(['view', 'numero' => $model->numero]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Deletes an existing Conta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $numero Numero
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($numero)
    {
        if (Yii::$app->user->can('gestorConta')) {
            $this->findModel($numero)->delete();
            Yii::$app->session->setFlash('success', 'Registro excluido com sucesso');
            return $this->redirect(['index']);
        } else {
            return $this->redirect(['error']);
        }
    }

    /**
     * Finds the Conta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $numero Numero
     * @return Conta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($numero)
    {
        if (($model = Conta::findOne(['numero' => $numero])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
