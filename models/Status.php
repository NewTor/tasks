<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $status_name
 *
 * @property Tasks[] $tasks
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * Table name
     * @return string
     */
    public static function tableName()
    {
        return 'status';
    }
    /**
     * Validate rules
     * @return array
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['status_name'], 'string', 'max' => 255],
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
            'status_name' => 'Status Name',
        ];
    }
    /**
     * Tasks relation
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['status_id' => 'id']);
    }
    /**
     * Массив записей таблицы Status
     * @return array
     */
    public static function getAsArray()
    {
        $result = [];
        $statuses = Status::find()->all();
        foreach ($statuses as $status) {
            $result[$status->id] = $status->status_name;
        }
        return  $result;
    }
    /**
     * DataProvider для GridView
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Status::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['elements_per_page']['statuses'],
            ],
        ]);
        $this->load($params);
        return $dataProvider;
    }

}
