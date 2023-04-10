<?php


namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Tasks;
use frontend\models\Replies;
use frontend\models\TasksQuery;
use Yii;

class TasksController extends SecuredController
{
    public function actionIndex()
    {
        $task = new Tasks();
        $task->load(Yii::$app->request->post());

        $taskQuery = $task->getSearchQuery();
        $categories = Categories::find()->asArray()->all();

        $models = $taskQuery->all();

        return $this->render('index',
            ['models'=> $models,
            'task'=>$task,
            'categories'=>$categories]);
    }
    public function actionView ($id)
    {   $task = new Tasks();
        $taskQuery = $task->getTask($id);
        return $this->render('view',
            ['data'=>$taskQuery,
                'task_host'=>$taskQuery->getOwner(),
                'task_performer'=>$taskQuery->getPerformer(),
                'task_replies'=>$taskQuery->getReplies(),
                'task_owner'=>$taskQuery->getOwner()]);
    }
    public function actionAdd()
    {
        $task = new Tasks();
        $categories = Categories::find()->orderBy('name')->all();
        if (Yii::$app->request->getIsPost())
        {
            $task->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format=Response::FORMAT_JSON;

                return ActiveForm::validate($task);
            }

            if ($task->validate())
            {
                $task->save(false);
                $this->goHome();
            }
        }
        return $this->render('add',['model'=>$task,'categories'=>$categories]);
    }
}