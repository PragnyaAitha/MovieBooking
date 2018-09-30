<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seat".
 *
 * @property int $id
 * @property int $seat_no
 * @property int $cinema_hall_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CinemaHall $cinemaHall
 * @property SeatBooked[] $seatBooked
 */
class Seat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seat_no', 'cinema_hall_id', 'created_at', 'updated_at'], 'required'],
            [['seat_no', 'cinema_hall_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cinema_hall_id'], 'exist', 'skipOnError' => true, 'targetClass' => CinemaHall::className(), 'targetAttribute' => ['cinema_hall_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seat_no' => 'Seat No',
            'cinema_hall_id' => 'Cinema Hall ID',
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
    public function getSeatBooked()
    {
        return $this->hasMany(SeatBooked::className(), ['seat_id' => 'id']);
    }

    public function getSeatNos($seatIds)
    {
        return $this->find()->select('seat_no')->where(['IN', 'id', $seatIds])->all();
    }

    public function getSeatIds($cinemaHallId, $seatNumbers)
    {
        return $this->find()->select('id')->where(['cinema_hall_id' => $cinemaHallId])
        ->andWhere(['IN', 'seat_no', $seatNumbers])->all();
    }
}
