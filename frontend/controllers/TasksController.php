<?php

namespace frontend\controllers;

use Yii;
use common\models\Tasks;
use common\models\Company;
use common\models\Status;
use common\models\TasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post('txtexport')) {
            
            $filename = "docs/tasks_".date("Ymd_Hi").".txt";
        
            //$taskList = Tasks::find()->all();
            //$companyList = Company::getCompanyList();

            $searchModel = new TasksSearch();
            $taskList = $searchModel->exportSearch(Yii::$app->request->queryParams);        

            foreach ($taskList as $task) {

                $body = "Компания: ".$task->companyLabel."\r\n".
                        "Дата получения: ".$task->date_get."\r\n".
                        "Дата завершения: ".$task->date_finish."\r\n".
                        "Постановщик: ".$task->author."\r\n".
                        "Задача: ".$task->message."\r\n".
                        "Комментарий: ".$task->comment."\r\n".
                        "-------------------------------------------------------\r\n";
            
                file_put_contents($filename, $body, FILE_APPEND);            
            }
        }
        
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusList = Status::getStatusList();
        $companyList = Company::getCompanyList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList,
            'companyList' => $companyList
        ]);
    }
    
    public function actionTxtexport()
    {
        $filename = "docs/tasks_".date("Ymd_Hi").".txt";
        
            //$taskList = Tasks::find()->all();
            //$companyList = Company::getCompanyList();

            $searchModel = new TasksSearch();
            $taskList = $searchModel->exportSearch(Yii::$app->request->queryParams);        

            foreach ($taskList as $task) {

                $body = "Компания: ".$task->companyLabel."\r\n".
                        "Дата получения: ".$task->date_get."\r\n".
                        //"Дата завершения: ".$task->date_finish."\r\n".
                        "Постановщик: ".$task->author."\r\n".
                        "Задача: ".$task->message."\r\n".
                        "Комментарий: ".$task->comment."\r\n".
                        "-------------------------------------------------------\r\n";
            
                file_put_contents($filename, $body, FILE_APPEND);            
            }
    }

    /**
     * Displays a single Tasks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tasks();
        $statusList = Status::getStatusList();
        $companyList = Company::getCompanyList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            
            $model->date_get = date('Y-m-d H:i:s');
            $model->date_start = date('Y-m-d H:i:s');
            $model->statusId = 2;
            
            return $this->renderAjax('create', [
                'model' => $model,
                'statusList' => $statusList,
                'companyList' => $companyList
            ]);
        }
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $statusList = Status::getStatusList();
        $companyList = Company::getCompanyList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'statusList' => $statusList,
                'companyList' => $companyList
            ]);
        }
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
