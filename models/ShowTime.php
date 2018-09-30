<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "show_time".
 *
 * @property int $id
 * @property string $timing
 * @property string $created_at
 * @property string $updated_at
 */
class ShowTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'show_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timing', 'created_at', 'updated_at'], 'required'],
            [['timing', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timing' => 'Timing',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
