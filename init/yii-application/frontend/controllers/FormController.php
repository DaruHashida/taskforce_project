<?php


namespace frontend\controllers;
use frontend\models\Users;
use frontend\models\Cities;
use frontend\models\LoginForm;
use yii\widgets\ActiveForm;
use Yii;

class FormController extends \yii\web\Controller
{ public function actionSignup()
    {
        $user = new Users();
        $cities = Cities::find()->orderBy('city')->all();
        if (Yii::$app->request->getIsPost())
        {
            $user->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format=Response::FORMAT_JSON;

                return ActiveForm::validate($user);
            }

            if ($user->validate())
            {
                $user->password = Yii::$app->security->generatePasswordHash($user->password);
                $user->save(false);
                $this->goHome();
            }
        }
        return $this->render('signup',['model'=>$user,'cities'=>$cities]);
    }
    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if (\Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                \Yii::$app->user->login($loginForm->getUser());

                return $this->goHome();
            }
        }
    }
}