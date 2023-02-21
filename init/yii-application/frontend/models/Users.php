<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string $user_registration_date
 * @property string|null $user_name
 * @property string|null $user_img
 * @property string|null $user_email
 * @property string|null $birth_date
 * @property string|null $user_description
 * @property string|null $telegram
 * @property string|null $role
 * @property string|null $reputation
 * @property string|null $own_tasks
 * @property string|null $performing_tasks
 * @property string|null $specialization
 * @property string|null $user_city
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_registration_date', 'birth_date'], 'safe'],
            [['user_name', 'user_img', 'user_email', 'user_description', 'telegram', 'role', 'reputation', 'own_tasks', 'performing_tasks', 'specialization', 'user_city'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_registration_date' => 'User Registration Date',
            'user_name' => 'User Name',
            'user_img' => 'User Img',
            'user_email' => 'User Email',
            'birth_date' => 'Birth Date',
            'user_description' => 'User Description',
            'telegram' => 'Telegram',
            'role' => 'Role',
            'reputation' => 'Reputation',
            'own_tasks' => 'Own Tasks',
            'performing_tasks' => 'Performing Tasks',
            'specialization' => 'Specialization',
            'user_city' => 'User City',
        ];
    }
}
