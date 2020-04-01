<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $email 邮箱
 * @property int $is_admin 是否是超级管理员 1表示是 0 表示不是
 * @property int $status 状态 1：有效 0：无效
 * @property string $updated_time 最后一次更新时间
 * @property string $created_time 插入时间
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_admin', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'is_admin' => 'Is Admin',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
