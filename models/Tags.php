<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property string $tag_name
 *
 * @property TagsTasks[] $tagsTasks
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * Table name
     * @return string
     */
    public static function tableName()
    {
        return 'tags';
    }
    /**
     * Validate rules
     * @return array
     */
    public function rules()
    {
        return [
            [['tag_name'], 'required'],
            [['tag_name'], 'string', 'max' => 255],
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
            'tag_name' => 'Tag Name',
        ];
    }
    /**
     * TagsTasks relation
     * @return \yii\db\ActiveQuery
     */
    public function getTagsTasks()
    {
        return $this->hasMany(TagsTasks::className(), ['tag_id' => 'id']);
    }
    /**
     * Массив записей таблицы Tags
     * @return array
     */
    public static function getAsArray()
    {
        $result = [];
        $tags = Tags::find()->all();
        foreach ($tags as $tag) {
            $result[$tag->id] = $tag->tag_name;
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
        $query = Tags::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['elements_per_page']['tags'],
            ],
        ]);
        $this->load($params);
        return $dataProvider;
    }




}
