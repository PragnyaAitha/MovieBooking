<?php

namespace app\models;

use Yii;
use yii\date;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $ticket_date
 * @property double $ticket_price
 * @property int $cinema_hall_id
 * @property int $movie_id
 * @property string $show_time_id
 * @property int $city_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CinemaHall $cinemaHall
 * @property City $city
 * @property Movie $movie
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_date', 'ticket_price', 'cinema_hall_id', 'movie_id', 'show_time_id', 'city_id'], 'required'],
            [['ticket_date', 'show_time_id', 'created_at', 'updated_at'], 'safe'],
            [['ticket_price'], 'number'],
            [['cinema_hall_id', 'movie_id', 'city_id'], 'integer'],
            [['cinema_hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => CinemaHall::className(), 'targetAttribute' => ['cinema_hall_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::className(), 'targetAttribute' => ['movie_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_date' => 'Ticket Date',
            'ticket_price' => 'Ticket Price',
            'cinema_hall_id' => 'Cinema Hall ID',
            'movie_id' => 'Movie ID',
            'show_time_id' => 'Show Time ID',
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

    // get the ticket data for a movie in a city between two mentioned dates.
    public function getTicketsBetweenTwoDates($movie_id, $city_id, $date1, $date2){
        return $this->find()->where(['movie_id' => $movie_id, 'city_id' => $city_id])
            ->andWhere(['>=', 'ticket_date', $date1])
            ->andWhere(['<=', 'ticket_date', $date2])
            ->all();
    }

    // get the ticket data for a movie in a city.
    public function getTicketShowsAndCinemaHallData($movie_id, $city_id){
        $movie = new Movie();
        $movie = $movie->getMovie($movie_id);

        $currentDate = date('Y-m-d');
        $releaseDate = date($movie->release_date);
        $endDate = date($movie->end_date);
        $sevenDaysDateFromToday = strtotime("+6 day");
        $sevenDaysDateFromToday = date('Y-m-d', $sevenDaysDateFromToday);
        $sevenDaysDateFromReleaseDay = strtotime($releaseDate."+6 day");
        $sevenDaysDateFromReleaseDay = date('Y-m-d', $sevenDaysDateFromReleaseDay);
        
        if($endDate < $currentDate){
            return "{}";
        }
        // Assuming that movies run for atleast 7 days
        if($releaseDate >= $currentDate){
            return $this->getTicketsBetweenTwoDates($movie_id, $city_id, $releaseDate, $sevenDaysDateFromReleaseDay);
        }
        if($endDate >= $sevenDaysDateFromToday){
            return $this->getTicketsBetweenTwoDates($movie_id, $city_id, $currentDate, $sevenDaysDateFromToday);
        }else{
            return $this->getTicketsBetweenTwoDates($movie_id, $city_id, $currentDate, $endDate);
        }
    }
}
