<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "annotation".
 *
 * @property int $id
 * @property string $value
 * @property string $item_id
 *
 * @property Item $item
 */
class Annotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'annotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['item_id'], 'required'],
            [['item_id'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'generic_file_name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Value'),
            'item_id' => Yii::t('app', 'Item ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['generic_file_name' => 'item_id']);
    }
}
