<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $status_id
 * @property string $name
 * @property string $priority
 *
 * @property TagsTasks[] $tagsTasks
 * @property Status $status
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
            [['status_id'], 'integer'],
            [['name'], 'required'],
            [['name', 'priority'], 'string'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'Status ID',
            'name' => 'Name',
            'priority' => 'Priority',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsTasks()
    {
        return $this->hasMany(TagsTasks::className(), ['task_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('tags_tasks', ['task_id' => 'id']);
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tasks::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['id', 'status_id', 'name', 'tags', 'priority'],
            ],
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
        $this->load($params);

        return $dataProvider;
    }
}
