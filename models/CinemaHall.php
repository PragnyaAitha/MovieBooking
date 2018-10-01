<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Booking;
use app\models\SeatBooked;
use app\models\Seat;

/**
 * This is the model class for table "cinema_hall".
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $theatre_id
 *
 * @property Booking[] $bookings
 * @property City $city
 * @property Theatre $theatre
 * @property Seat[] $seats
 * @property Ticket[] $tickets
 */
class CinemaHall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cinema_hall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'city_id', 'created_at', 'updated_at'], 'required'],
            [['city_id', 'theatre_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['theatre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Theatre::className(), 'targetAttribute' => ['theatre_id' => 'id']],
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
            'city_id' => 'City ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'theatre_id' => 'Theatre ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['cinema_hall_id' => 'id']);
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
    public function getTheatre()
    {
        return $this->hasOne(Theatre::className(), ['id' => 'theatre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeats()
    {
        return $this->hasMany(Seat::className(), ['cinema_hall_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['cinema_hall_id' => 'id']);
    }

    // get the seat layout for a cinema hall for a movie at the showtime
    public function getUnbookedSeats($city_id, $movie_id, $cinema_hall_id, $show_time_id){
        //get all the bookings for that movie in the cinema hall at the mentioned show time
        $bookingIds = Booking::find()->select('id')->where(['city_id' => $city_id, 'movie_id' => $movie_id, 'cinema_hall_id' => $cinema_hall_id, 'show_time_id' => $show_time_id])->all();
        $bookingIds = ArrayHelper::getColumn($bookingIds, 'id');

        //get all the booked seat ids 
        $bookedSeatIds = SeatBooked::find()->select('seat_id')->where(['IN', 'booking_id', $bookingIds])->all();
        $bookedSeatIds = ArrayHelper::getColumn($bookedSeatIds, 'seat_id');

        //get all the unbooked seat numbers
        $unbookedSeats = Seat::find()->select('seat_no')->where(['cinema_hall_id' => $cinema_hall_id])
        ->andWhere(['NOT IN', 'id', $bookedSeatIds])->all();

        return $unbookedSeats;
    }
}
