<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\LoginForm;
use src\logic\DataToSQLConverter;
use yii\widgets\ActiveForm;
AppAsset::register($this);
?>
<?php $form = ActiveForm::begin(['enableAjaxValidation'=>true, 'action'=>['login']]); ?>
<h2>Вход на сайт</h2>
<p>
    <?= $form->field($model, 'email', ['labelOptions' => ['class' => 'form-modal-description'],
        'inputOptions' => ['class' => 'enter-form-email input input-middle']]);?>
</p>
<p>
    <?= $form->field($model, 'password', [ 'labelOptions' => ['class' => 'form-modal-description'],
        'inputOptions' => ['class' => 'enter-form-email input input-middle']])->passwordInput();?>
</p>
<button class="button" type="submit">Войти</button>
<?php ActiveForm::end(); ?>
<button class="form-modal-close" type="button">Закрыть</button>

