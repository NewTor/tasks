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
 * @property string $uuid
 *
 * @property TagsTasks[] $tagsTasks
 * @property Status $status
 * @property Tags[] $tags
 */
class Tasks extends \yii\db\ActiveRecord
{
    public $prioritet = [
        '0' => 'Низкий',
        '1' => 'Средний',
        '2' => 'Высокий',
    ];
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
            [['tags'], 'safe'],
            [['uuid', 'name', 'priority'], 'string'],
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
            'tags' => 'Tags',
            'uuid' => 'UUID',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
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
     * @return mixed
     */
    public function getPriv()
    {
        return $this->prioritet[$this->priority];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tasks::find()->joinWith('tags');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['uuid', 'name', 'status_id', 'priority'],
                'defaultOrder' => [
                    'status_id' => SORT_ASC,
                    'priority' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 40,
            ],
        ]);
        $this->load($params);


        return $dataProvider;
    }
}
