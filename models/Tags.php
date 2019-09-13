<?php

namespace app\models;

use Yii;

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_name'], 'required'],
            [['tag_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsTasks()
    {
        return $this->hasMany(TagsTasks::className(), ['tag_id' => 'id']);
    }
}
