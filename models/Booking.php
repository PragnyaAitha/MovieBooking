<?php

namespace app\models;

use Yii;
use yii\date;
use yii\helpers\ArrayHelper;
use app\models\Seat;
use app\models\SeatBooked;

/**
 * This is the model class for table "booking".
 *
 * @property int $id
 * @property string $booking_date
 * @property int $movie_id
 * @property int $user_id
 * @property int $cinema_hall_id
 * @property string $show_time_id
 * @property double $booking_value
 * @property int $city_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CinemaHall $cinemaHall
 * @property City $city
 * @property Movie $movie
 * @property User $user
 * @property SeatBooked[] $seatBooked
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['booking_date', 'movie_id', 'user_id', 'cinema_hall_id', 'show_time_id', 'booking_value', 'city_id'], 'required'],
            [['booking_date', 'show_time_id', 'created_at', 'updated_at'], 'safe'],
            [['movie_id', 'user_id', 'cinema_hall_id', 'city_id'], 'integer'],
            [['booking_value'], 'number'],
            [['cinema_hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => CinemaHall::className(), 'targetAttribute' => ['cinema_hall_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::className(), 'targetAttribute' => ['movie_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booking_date' => 'Booking Date',
            'movie_id' => 'Movie ID',
            'user_id' => 'User ID',
            'cinema_hall_id' => 'Cinema Hall ID',
            'show_time_id' => 'Show Time ID',
            'booking_value' => 'Booking Value',
            'city_id' => 'City ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCinemaHall()
    {
        return $this->hasOne(CinemaHall::className(), ['id' => 'cinema_hall_id']);
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
    public function getMovie()
    {
        return $this->hasOne(Movie::className(), ['id' => 'movie_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeatBooked()
    {
        return $this->hasMany(SeatBooked::className(), ['booking_id' => 'id']);
    }

    public function getBookingInfo($bookingDate, $movieId, $userId, $cinemaHallId, $showTimeId, $cityId)
    {
        return $this->find()->select('id')->where(['booking_date' => $bookingDate, 'movie_id' => $movieId, 'user_id' => $userId, 'cinema_hall_id' => $cinemaHallId, 'show_time_id' => $showTimeId, 'city_id' => $cityId])->all();
    }

    public function addBookingInfo($requestData){
        $booking = new Booking();

        $booking->booking_date = $requestData['bookingDate'];
        $booking->movie_id = $requestData['movieId'];
        $booking->user_id = $requestData['userId'];
        $booking->cinema_hall_id = $requestData['cinemaHallId'];
        $booking->show_time_id = $requestData['showTimeId'];
        $booking->booking_value = $requestData['bookingValue'];
        $booking->city_id = $requestData['cityId'];
        $bookingEntry = $booking->save(); // save booking info

        $seatBooked = new SeatBooked(); // save booked seats info
        $seatBooked->addSeatBookedInfo($booking['id'], $requestData['cinemaHallId'], $requestData['seatNumbers']);
    }
}
