<?php


namespace app\controllers;

use app\models\Tasks;

class TaskController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::findAll(['status_id'=>1]);

        return $this->render('index', ['models'=> $tasks]);
    }
}