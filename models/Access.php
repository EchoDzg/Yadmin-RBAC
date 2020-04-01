<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property string $title 权限名称
 * @property string $urls json 数组
 * @property int $status 状态 1：有效 0：无效
 * @property string $updated_time 最后一次更新时间
 * @property string $created_time 插入时间
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%access}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['urls'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'urls' => 'Urls',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
