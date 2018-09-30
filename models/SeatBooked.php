<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Seat;

/**
 * This is the model class for table "seat_booked".
 *
 * @property int $id
 * @property int $booking_id
 * @property int $seat_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Booking $booking
 * @property Seat $seat
 */
class SeatBooked extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seat_booked';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['booking_id', 'seat_id', 'created_at', 'updated_at'], 'required'],
            [['booking_id', 'seat_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['booking_id'], 'exist', 'skipOnError' => true, 'targetClass' => Booking::className(), 'targetAttribute' => ['booking_id' => 'id']],
            [['seat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seat::className(), 'targetAttribute' => ['seat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booking_id' => 'Booking ID',
            'seat_id' => 'Seat ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(Booking::className(), ['id' => 'booking_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeat()
    {
        return $this->hasOne(Seat::className(), ['id' => 'seat_id']);
    }

    public function getSeatsBooked($bookingIds)
    {
        $seatIds = SeatBooked::find()->select(['seat_id'])
                    ->where(['IN', 'booking_id', $bookingIds])
                    ->all();
        return $seatIds;
    }

    public function addSeatBookedInfo($bookingId, $cinemaHallId, $seatNumbers){
        $seat = new Seat();
        $seatIds = $seat->getSeatIds($cinemaHallId, $seatNumbers);
        $seatIds = ArrayHelper::getColumn($seatIds, 'id');
        
        foreach ($seatIds as $seatId) {
            $seatBooked = new SeatBooked();
            $seatBooked->booking_id = $bookingId;
            $seatBooked->seat_id = (int)$seatId;
            $seatBooked->created_at = date('Y-m-d H:m:s');
            $seatBooked->updated_at = date('Y-m-d H:m:s');
            $seatBooked->save();
        } 
    }
}
