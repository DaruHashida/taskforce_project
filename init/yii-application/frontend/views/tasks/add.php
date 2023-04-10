<?php
use app\models\City;
use app\models\User;
use yii\widgets\ActiveForm;
?>
<div class="add-task-form regular-form">
        <?php $form = ActiveForm::begin();?>
        <h3 class="head-main head-main">Публикация нового задания</h3>
        <div class="form-group">
            <?=$form->field($model,'task_title')->label('Опишите суть работы',['class'=>'control-label'])?>
            <!--<span class="help-block">Error description is here</span>-->
        </div>
        <div class="form-group">
            <?=$form->field($model, 'task_description')->textarea(['rows' => '6','id'=>'username'])->
            label('Подробности задания',['class'=>'control-label'])?>
            <!--<span class="help-block">Error description is here</span>-->
        </div>
        <div class="form-group">
            <?=$form->field($model,'task_category')->dropDownList(array_column($categories, 'name', 'name'))->
            label('Категория',['class'=>'control-label'])?>
<!--            <span class="help-block">Error description is here</span>-->
        </div>
        <!--<div class="form-group">
            <?/*=$form->field($model,'task_coordinates')->label('Локация',['class'=>'control-label'])*/?>
            <span class="help-block">Error description is here</span>
        </div>-->
        <div class="half-wrapper">
            <div class="form-group">
                <?=$form->field($model,'task_price')->label('Бюджет',['class'=>'control-label'])?>
               <!-- <span class="help-block">Error description is here</span>-->
            </div>
            <div class="form-group">
                <?= $form->field($model, 'task_expire_date')->widget(\yii\jui\DatePicker::className(),
                    [       'language' => 'ru',
                            'dateFormat'=>'yyyy-MM-dd'])?>
                <!--<span class="help-block">Error description is here</span>-->
            </div>
        </div>
        <div>
            <?= $form->field($model, 'task_host')->hiddenInput(['value'=>Yii::$app->getUser()->getIdentity()->user_id])->label(false)?>
        </div>
        <!--<p class="form-label">Файлы</p>
        <div class="new-file">
            Добавить новый файл
        </div>-->
        <button class="button button--blue" type="submit">Опубликовать</button>
        <?php ActiveForm::end(); ?>
</div>
