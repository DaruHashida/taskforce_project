<?php


namespace frontend\controllers;
use frontend\models\Users;
use Yii;

class UsersController extends \yii\web\Controller
{   public function actionView ($id)
    {
    $user = new Users();
    $userQuery = $user->getUser($id);
    return ($this->render('view', ['data'=>$userQuery]));
    }

}