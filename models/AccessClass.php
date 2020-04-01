<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%access_class}}".
 *
 * @property int $id 自增id
 * @property string $class_name 分类名
 * @property string $updated_time
 * @property string $created_time
 * @property int $status 状态 1：有效 0：无效
 */
class AccessClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%access_class}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_time', 'created_time'], 'safe'],
            [['status'], 'integer'],
            [['class_name'],'required','string', 'max' => 50,'message'=>'分类名必须填写.','on' => 'class'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
            'status' => 'Status',
        ];
    }
}
