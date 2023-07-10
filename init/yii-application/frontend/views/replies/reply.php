<?php
use yii\widgets\ActiveForm;
use frontend\models\Replies;
$reply=Replies::getInstance();
$user_id = Yii::$app->getUser()->getIdentity()->user_id;
?>
<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin(['action'=>Yii::$app->request->baseUrl.'/replies/response']);?>
            <form>
                    <?=$form->field($reply, 'description', ['labelOptions' => ['class' => 'control-label'],
                        'inputOptions' => ['class' => 'enter-form-email input input-middle']])->input('textarea')->label('Ваш комментарий')?>
                </div>
                <div class="form-group">
                    <?=$form->field($reply, 'price', ['labelOptions' => ['class' => 'control-label']])->input('text')->label('Стоимость')?>
                </div>
                <div>
                    <?=$form->field($reply,'task_id')->hiddenInput(['value'=>$task_id])->label(false)?>
                </div>
                <div>
                    <?=$form->field($reply,'user_id')->hiddenInput(['value'=>$user_id])->label(false)?>
                </div>
                <input type="submit" class="button button--pop-up button--blue" value="Завершить">
                <?php ActiveForm::end();?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
