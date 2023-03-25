<?php

namespace frontend\models;

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
 * @property string|null $bio
 * @property string|null $user_city
 * @property int|null $responces_count
 * @property string|null $phonenumber
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
            [['responces_count'], 'integer'],
            [['user_name', 'user_img', 'user_email', 'user_description', 'telegram', 'role', 'reputation', 'own_tasks', 'performing_tasks', 'specialization', 'bio', 'user_city', 'phonenumber'], 'string', 'max' => 50],
            [['user_email'], 'unique'],
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
            'bio' => 'Bio',
            'user_city' => 'User City',
            'responces_count' => 'Responces Count',
            'phonenumber' => 'Phonenumber',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
    /**
     * @param $id
     * @return Users|null
     */
    public function getUser($id)
    {
        return self::findOne($id);
    }

    /**
     * @return int
     */
    public function getAge()
    {   $secs_in_year = 31536000;
        $birthday = strtotime($this->birth_date);
        $now_time = time();
        $diff = $now_time-$birthday;
        return intdiv($diff,$secs_in_year);
    }

    /**
     * @return false|string
     */
    public function getDate()
    {
        $date=date_create($this->user_registration_date);
        return date_format($date,"Y F d");
    }
}
