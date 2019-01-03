<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $generic_file_name
 * @property string $original_file_name
 * @property string $file_description
 * @property string $user_id
 *
 * @property Annotation[] $annotations
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['generic_file_name', 'original_file_name', 'user_id'], 'required'],
            [['generic_file_name', 'original_file_name', 'user_id'], 'string', 'max' => 255],
            [['file_description'], 'string', 'max' => 512],
            [['generic_file_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'generic_file_name' => Yii::t('app', 'Generic File Name'),
            'original_file_name' => Yii::t('app', 'Original File Name'),
            'file_description' => Yii::t('app', 'File Description'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnnotations()
    {
        return $this->hasMany(Annotation::className(), ['item_id' => 'generic_file_name']);
    }
}
