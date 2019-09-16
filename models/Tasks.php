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
    /**
     * @var array priority
     */
    public $prioritet = [
        '0' => 'Низкий',
        '1' => 'Средний',
        '2' => 'Высокий',
    ];
    /**
     * Table name
     */
    public static function tableName()
    {
        return 'tasks';
    }
    /**
     * Validate rules
     * @return array
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
     * Fields attributes
     * @return array
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
     * TagsTasks relation
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(TagsTasks::className(), ['task_id' => 'id']);
    }
    /**
     * Status relation
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
     * DataProvider для GridView
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
                'pageSize' => Yii::$app->params['elements_per_page']['tasks'],
            ],
        ]);
        $this->load($params);
        // Фильтрация по тексту задачи
        if(isset($params['name']) && $params['name'] != '') {
            $query->andFilterWhere(['like', 'tasks.name', trim($params['name'])]);
        }
        // Фильтрация по идентификатору
        if(isset($params['uuid']) && $params['uuid'] != '') {
            $query->andFilterWhere(['like', 'tasks.uuid', trim($params['uuid'])]);
        }
        // Фильтрация по статусам
        if(isset($params['status']) && (!empty($params['status']) || $params['status'] != 0)) {
            $query->andFilterWhere(['tasks.status_id' => $params['status']]);
        }
        // Фильтрация по приоритету
        if(isset($params['priority']) && (!empty($params['priority']) || $params['priority'] != 0)) {
            $query->andFilterWhere(['tasks.priority' => $params['priority']]);
        }
        // Фильтрация по хэштегам
        if(isset($params['tags']) && (!empty($params['tags']) || $params['tags'] != 0)) {
            $query->andFilterWhere(['tags_tasks.tag_id' => $params['tags']]);
        }
        return $dataProvider;
    }


}
