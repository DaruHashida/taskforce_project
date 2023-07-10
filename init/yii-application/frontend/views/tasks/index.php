<?php
/**
* @var Task[] $models
* @var $this View
*/

use frontend\models\Tasks;
use frontend\models\TasksQuery;
use frontend\models\Categories;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


?>
 <div class="left-column">
            <h3 class="head-main head-task">Новые задания</h3>
            <?php if (count($models) != 0):?>
            <?php foreach ($models as $model):?>
                    <?php
                    $relative_string = Yii::$app->formatter->asRelativeTime($model->task_creation_date);
                    $nazad = strpos($relative_string," назад");
                    $relative_string_bez_nazad = str_replace(' назад','',$relative_string);
                    ?>
            <div class="task-card">
                <div class="header-task">
                    <a  href="http://taskforce.local/tasks/<?=$model->task_id?>" class="link link--block link--big"><?=Html::encode($model->task_title)?></a>
                    <p class="price price--task"><?=$model->task_price.' ₽';?></p>
                </div>
                <p class="info-text"><?=$nazad?"<span class=\"current-time\">$relative_string_bez_nazad </span> назад":
                        "<span class=\"current-time\">$relative_string</span>"?></p>
                <p class="task-text"><?=Html::encode(BaseStringHelper::truncate($model->task_description, 200));?>
                </p>
                <div class="footer-task">
                    <p class="info-text town-text"><?=$model->task_coordinates;?></p>
                    <p class="info-text category-text"><?=$model->task_category;?></p>
                    <a href="http://taskforce.local/tasks/<?=$model->task_id?>" class="button button--black">Смотреть Задание</a>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif;?>
            <!--<div class="task-card">
                <div class="header-task">
                    <a  href="#" class="link link--block link--big">Убраться в квартире после вписки</a>
                    <p class="price price--task">4700 ₽</p>
                </div>
                <p class="info-text"><span class="current-time">4 часа </span>назад</p>
                <p class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet tempor
                    nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet augue accumsan tincidunt.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet tempor
                    nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet augue accumsan tincidunt.
                </p>
                <div class="footer-task">
                    <p class="info-text town-text">Санкт-Петербург, Центральный район</p>
                    <p class="info-text category-text">Переводы</p>
                    <a href="#" class="button button--black">Смотреть Задание</a>
                </div>
            </div>
            <div class="task-card">
                <div class="header-task">
                    <a  href="#" class="link link--block link--big">Перевезти груз на новое место</a>
                    <p class="price price--task">18750 ₽</p>
                </div>
                <p class="info-text"><span class="current-time">4 часа </span>назад</p>
                <p class="task-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas varius tortor nibh, sit amet tempor
                    nibh finibus et. Aenean eu enim justo. Vestibulum aliquam hendrerit molestie. Mauris malesuada nisi sit amet augue accumsan tincidunt.
                </p>
                <div class="footer-task">
                    <p class="info-text town-text">Санкт-Петербург, Центральный район</p>
                    <p class="info-text category-text">Переводы</p>
                    <a href="#" class="button button--black">Смотреть Задание</a>
                </div>
            </div>-->
</div>
<div class="right-column">
    <div class="right-card black">
        <div class="search-form">
            <?php $form = ActiveForm::begin() ?>
           <!-- /*(['id' => 'search-form',
                'options'=>['class'=>'search-form'],
                'errorCssClass'=>'',
                'fieldConfig'=>
                    [
                        'template'=>"{label}\n\r{input}",
                        'options'=>['class'=>'form-group'],
                    ]

            ]);*/
-->
                <h4 class="head-card">Категории</h4>
                <div class="form-group">
                    <div class="checkbox-wrapper">
                        <?=Html::activeCheckboxList($task, 'task_category', array_column($categories,'name','name'),
                            ['tag'=>null, 'itemOptions'=>['labelOptions'=>['class'=>'control-label']]]);?>
                    </div>
                        <h4 class="head-card">Дополнительно</h4>
                    <div class="checkbox-wrapper">
                        <?=$form->field($task,'noResponses')->checkbox(['labelOptions'=>['class'=>'control-label']]);?>
                    </div>
                    <div class="checkbox-wrapper">
                        <?=$form->field($task,'noLocation')->checkbox(['labelOptions'=>['class'=>'control-label']]);?>
                    </div>
                        <h4 class="head-card">Дополнительно</h4>
                        <?=$form->field($task, 'filterPeriod', ['template'=>'{input}'])->dropDownList([
                                '3600'=>'За последний час', '86400'=>'За сутки','604800'=>'За неделю'], ['prompt'=>'Выбрать']);?>
                <input type="submit" class="button button--blue" value="Искать">
        <?php ActiveForm::end();?>
            </form>
        </div>
    </div>
</div>