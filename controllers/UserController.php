<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use app\models\Booking;
use app\models\SeatBooked;
use app\models\Seat;

class UserController extends ActiveController
{
	public $modelClass = 'app\models\User';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFetchBookedSeats($bookingDate, $movieId, $userId, $cinemaHallId, $showTimeId, $cityId)
    {
    	$booking = new Booking();
    	$bookingIds = $booking->getBookingInfo($bookingDate, $movieId, $userId, $cinemaHallId, $showTimeId, $cityId);
    	$bookingIds = ArrayHelper::getColumn($bookingIds, 'id');

    	$seatbooked = new SeatBooked();
    	$seatIds = $seatbooked->getSeatsBooked($bookingIds);
    	$seatIds = ArrayHelper::getColumn($seatIds, 'seat_id');

    	$seat = new Seat();
    	return $seat->getSeatNos($seatIds);
    }

}
