<?php

namespace frontend\models;

use Yii;
use frontend\models\Replies;
use frontend\models\Users;
use src\logic\Task;
use src\logic\CancelAction;
use src\logic\ReactAction;
use src\logic\FinishAction;
use src\logic\DenyAction;
use frontend\helpers\YandexMapHelper;

/**
 * This is the model class for table "tasks".
 *
 * @property int $task_id
 * @property string|null $task_creation_date
 * @property string|null $task_title
 * @property string|null $task_description
 * @property string|null $task_host
 * @property string|null $task_performer
 * @property string|null $task_expire_date
 * @property string|null $task_status
 * @property string|null $task_actions
 * @property string|null $task_coordinates
 * @property float $task_price
 * @property string|null $task_category
 */
class Tasks extends \yii\db\ActiveRecord
{
    public $noResponses;
    public $noLocation;
    public $filterPeriod;
    const STATUS_NEW = 'new';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_title', 'task_category','task_price','task_description'],'required'/*,'on'=>self::SCENARIO_DEFAULT*/],
            [['task_creation_date'], 'safe'],
            [['task_price'], 'number'],
            [['task_title', 'task_host', 'task_performer', 'task_expire_date', 'task_status', 'task_actions', 'task_coordinates', 'task_category'], 'string', 'max' => 50],
            [['task_description'], 'string', 'max' => 1000],
            ['task_expire_date', 'default', 'value' => null],
            ['task_expire_date', 'date', 'format' => 'php:Y-m-d']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_creation_date' => 'Дата публикации',
            'task_title' => 'Заголовок задания',
            'task_description' => 'Описание задания',
            'task_host' => 'Заказчик',
            'task_performer' => 'Исполнитель',
            'task_expire_date' => 'Время окончания задания',
            'task_status' => 'Статус',
            'task_actions' => 'Допустимые действия',
            'task_coordinates' => 'Местоположение',
            'task_price' => 'Цена',
            'task_category' => 'Категория',
        ];
    }
    public function getFile()
    {
        return $this->hasMany(File::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reply]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return Replies::find()->where(['task_id'=>$this->task_id])->all();
    }


    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['name' => 'task_category']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getStatus()
    {
        return $this->hasOne(Status::class, ['name' => 'task_status']);
    }

    /**
     * @return string|null
     */

    /**
     * @return mixed
     */

    public function getOwner()
    {
        return Users::find()->where(['user_id'=>$this->task_host])->one();
    }

    /**
     * @return mixed
     */
    public function getPerformer()
    {
        return Users::find()->where(['user_id'=>$this->task_performer])->one();
    }
    /*public function getPlace()
    {
        return $this->hasOne(Status::class, ['name' => 'task_status']);
    }*/

    /**
     * @return mixed
     */
    public function getSearchQuery()
    {
        $query = self::find();

        $query->andFilterWhere(['task_category'=>$this->task_category]);

        if ($this->noLocation) {
            $query->andWhere('task_location IS NULL');
        }

        if ($this->noResponses)
        {
            $query->joinWith('replies r')->andWhere('r.id IS NULL');
        }
        if ($this->filterPeriod)
        {
            $query->andWhere('UNIX_TIMESTAMP(tasks.task_creation_date > UNIX_TIMESTAMP()-:period', [':period'=>$this->filterPeriod]);
        }
        return $query->orderBy('task_creation_date DESC');
    }
    public function getTask($id)
    {
        $query = self::findOne($id);
        return $query;
    }
    /**
     *
     */
    public function possibleAction (int $user_id, ?string $status)
    {   $possible=[];
        if (!isset($status))
        {
        $status = 'STATUS_NEW';
        }
        $actions_map = [
            'STATUS_NEW' => [ReactAction::class, CancelAction::class],
            'STATUS_PROCESSING' => [DenyAction::class, FinishAction::class],
            'STATUS_FAILED'=>[],
            'STATUS_DONE'=>[]
        ];

        $possible_actions = $actions_map[$status];

        foreach ($possible_actions as $action)
        { if ($action::getUserProperties($user_id,$this))
        {
            array_push($possible, new $action($this->task_host, $this->task_performer));
        }
        }
        return $possible;
    }

    public function beforeSave($insert)
    {
        if ($this->task_coordinates) {
            $yandexHelper = new YandexMapHelper(getenv('YANDEX_API_KEY'));
            $coords = $yandexHelper->getCoordinates($this->city->name, $this->location);

            if ($coords) {
                [$lat, $long] = $coords;

                $this->lat = $lat;
                $this->long = $long;
            }
        }

        parent::beforeSave($insert);

        return true;
    }

}
