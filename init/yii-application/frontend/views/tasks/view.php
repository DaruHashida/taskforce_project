<?php
/**
 *
 */
use frontend\models\Tasks;
use frontend\models\TasksQuery;
use frontend\models\Categories;
use frontend\models\Replies;
use frontend\models\Users;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;
use frontend\assets\AppAsset;
AppAsset::register($this);
?>
<link rel="stylesheet" href="taskforce.local\frontend\web\css">
<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?=Html::encode($data->task_title)?></h3>
        <p class="price price--big"><?=$data->task_price.' ₽'?></p>
    </div>
    <p class="task-description">
        <?=$data->task_description?></p>
    <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
    <a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
    <a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>
    <div class="task-map">
        <img class="map" src="<?=Yii::$app->request->baseUrl;?>/img/map.png"  width="725" height="346" alt="Новый арбат, 23, к. 1">
        <p class="map-address town"><?=$data->task_coordinates?></p>
        <!--<p class="map-address">Новый арбат, 23, к. 1</p>-->
    </div>
    <h4 class="head-regular"><О></О>тклики на задание</h4>
    
    <?php foreach ($task_replies as $reply):?>
        <?php
        $comment_user = Users::find()->where(['user_id'=>$reply->user_id])->one();
        ?>
        <div class="response-card">
            <img class="customer-photo" src="<?=Yii::$app->request->baseUrl;?>/img/<?=$comment_user->user_img?>" width="146" height="156" alt="Фото заказчиков">
            <div class="feedback-wrapper">
                <a href="/users/<?=$comment_user->user_id?>" class="link link--block link--big"><?=$comment_user->user_name?></a>
                <div class="response-wrapper">
                    <div class="stars-rating small">
                        <?php for($i=0;$i<$comment_user->reputation;$i++)
                        {echo("<span class=\"fill-star\"> </span>");}?>
                        <?php
                        if ($comment_user->reputation<5)
                        {for($i=0;$i<(5-$comment_user->reputation);$i++)
                        {echo("<span> </span>");}}?>
                    </div>

                    <p class="reviews"><?=$comment_user->responces_count?> отзыва</p>
                </div>
                <p class="response-message">
                    <?=$reply->description?>
                </p>
            </div>
            <div class="feedback-wrapper">
                <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->asRelativeTime($reply->dt_add)?> </span>назад</p>
                <p class="price price--small"><?=$reply->price.' ₽'?></p>
            </div>
            <div class="button-popup">
                <a href="#" class="button button--blue button--small">Принять</a>
                <a href="#" class="button button--orange button--small">Отказать</a>
            </div>
        </div>
    <?php endforeach;?>
    <div class="response-card">
        <img class="customer-photo" src="<?=Yii::$app->request->baseUrl;?>/img/man-sweater.png" width="146" height="156" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <a href="#" class="link link--block link--big">Дмитриев Андрей</a>
            <div class="response-wrapper">
                <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                <p class="reviews">8 отзывов</p>
            </div>
            <p class="response-message">
                Примусь за выполнение задания в течение часа, сделаю быстро и качественно.
            </p>

        </div>
        <div class="feedback-wrapper">
            <p class="info-text"><span class="current-time">2 часа </span>назад</p>
            <p class="price price--small">1999 ₽</p>
        </div>
        <div class="button-popup">
            <a href="#" class="button button--blue button--small">Принять</a>
            <a href="#" class="button button--orange button--small">Отказать</a>
        </div>
    </div>
</div>
<div class="right-column">
    <div class="right-card black info-card">
        <h4 class="head-card">Информация о задании</h4>
        <dl class="black-list">
            <dt>Категория</dt>
            <dd><?=$data->task_category?></dd>
            <dt>Дата публикации</dt>
            <dd><?=Yii::$app->formatter->asRelativeTime($data->task_creation_date)?></dd>
            <dt>Срок выполнения</dt>
            <dd><?=Yii::$app->formatter->asRelativeTime($data->task_expire_date)?></dd>
            <dt>Статус</dt>
            <dd><?=$data->task_status?></dd>
        </dl>
    </div>
    <div class="right-card white file-card">
        <h4 class="head-card">Файлы задания</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="#" class="link link--block link--clip">my_picture.jpg</a>
                <p class="file-size">356 Кб</p>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--clip">information.docx</a>
                <p class="file-size">12 Кб</p>
            </li>
        </ul>
    </div>
</div>