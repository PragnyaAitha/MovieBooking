<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movie".
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property int $city_id
 * @property string $release_date
 * @property string $end_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Booking[] $bookings
 * @property City $city
 * @property Ticket[] $tickets
 */
class Movie extends \yii\db\ActiveRecord
{
    const ACTIVE_MOVIE = 1;

    public static function tableName()
    {
        return 'movie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'is_active', 'city_id', 'release_date', 'end_date'], 'required'],
            [['is_active', 'city_id'], 'integer'],
            [['release_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'is_active' => 'Is Active',
            'city_id' => 'City ID',
            'release_date' => 'Release Date',
            'end_date' => 'End Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function activeMovies($city_id){
        //query to fetch avtive movies for a city, movies are active if is_active field is 1 
        return $this->find()->where(['is_active' => Movie::ACTIVE_MOVIE, 'city_id' => $city_id])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['movie_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['movie_id' => 'id']);
    }

    public function getMovie($movie_id)
    {
        return Movie::findOne(['id' => $movie_id]);
    }
}
