<?php

namespace app\controllers;

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
                    'class' => VerbFilter::className(),
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
        $searchModel = new ContaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conta model.
     * @param int $numero Numero
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($numero)
    {
        return $this->render('view', [
            'model' => $this->findModel($numero),
        ]);
    }

    /**
     * Creates a new Conta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Conta();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'numero' => $model->numero]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
        $model = $this->findModel($numero);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'numero' => $model->numero]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
        $this->findModel($numero)->delete();

        return $this->redirect(['index']);
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
