<?php

namespace app\models;

use Yii;

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
            [['task_creation_date'], 'safe'],
            [['task_price'], 'number'],
            [['task_title', 'task_host', 'task_performer', 'task_expire_date', 'task_status', 'task_actions', 'task_coordinates', 'task_category'], 'string', 'max' => 50],
            [['task_description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_creation_date' => 'Task Creation Date',
            'task_title' => 'Task Title',
            'task_description' => 'Task Description',
            'task_host' => 'Task Host',
            'task_performer' => 'Task Performer',
            'task_expire_date' => 'Task Expire Date',
            'task_status' => 'Task Status',
            'task_actions' => 'Task Actions',
            'task_coordinates' => 'Task Coordinates',
            'task_price' => 'Task Price',
            'task_category' => 'Task Category',
        ];
    }
}
