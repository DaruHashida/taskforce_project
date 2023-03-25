<?php
/**
 * @var Task[] $models
 * @var $this View
 */

use app\models\Task;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Просмотр новых заданий';
?>

<div class="left-column">
    <h3 class="head-main head-task">Новые задания</h3>
    <?php foreach ($models as $model):?>
        <div class="task-card">
            <div class="header-task">
                <a  href="#" class="link link--block link--big"><?=Html::encode($model->task_title)?></a>
                <p class="price price--task"><?=$model->task_price;?></p>
            </div>
            <p class="info-text"><?=Yii::$app->formatter->asRelativeTime($model->task_creation_date);?></p>
            <p class="task-text"><?=Html::encode(BaseStringHelper::truncate($model->task_description, 200));?>
            </p>
            <div class="footer-task">
                <p class="info-text town-text"><?=$model->task_coordinates;?></p>
                <p class="info-text category-text"><?=$model->task_category;?></p>
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
    <?php endforeach;?>
</div>