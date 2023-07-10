<?php
use app\models\City;
use app\models\User;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use frontend\assets\YandexAsset;
YandexAsset::register($this);
use yii\web\View;
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
<!-- ЖЫСЫ КОД АВТОПОДСКАЗКИ -->
        <?php $this->registerJsFile('/js/locationValidator.js',['depends' => [frontend\assets\YandexAsset::class]])?>


        <div class="form-group" id="map"></div>
        <div class="form-group">
            <?=$form->field($model,'task_coordinates', [
                'inputOptions' => [
                    'id' => 'location',
                ]])->label('Локация',['class'=>'control-label'])?>
            <span class="help-block">Error description is here</span>
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <?=$form->field($model,'task_price')->label('Бюджет',['class'=>'control-label'])?>
               <!-- <span class="help-block">Error description is here</span>-->
            </div>
            <div class="form-group">
                <?= $form->field($model,'task_expire_date')->input('date')?>
                <!--<span class="help-block">Error description is here</span>-->
            </div>
        </div>
        <div>
            <?= $form->field($model, 'task_host')->hiddenInput(['value'=>Yii::$app->getUser()->getIdentity()->user_id])->label(false)?>
        </div>
        <div>
            <?= $form->field($model, 'loc_validation')->hiddenInput(['id'=>'loc_valid'])->label(false)?>
        </div>
        <!--<p class="form-label">Файлы</p>
        <div class="new-file">
            Добавить новый файл
        </div>-->
        <button class="button button--blue" id="submit" type="submit">Опубликовать</button>
        <?php ActiveForm::end(); ?>
</div>
