<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theatre".
 *
 * @property int $id
 * @property int $city_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CinemaHall[] $cinemaHalls
 * @property City $city
 */
class Theatre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'theatre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'created_at', 'updated_at'], 'required'],
            [['city_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCinemaHalls()
    {
        return $this->hasMany(CinemaHall::className(), ['theatre_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
