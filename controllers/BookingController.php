<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use app\models\Booking;
use app\models\SeatBooked;
use app\models\Seat;

class BookingController extends ActiveController
{
	public $modelClass = 'app\models\Booking';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actions()
    {
    	$actions = parent::actions();
    	unset($actions['create']);
    	return $actions;
    }

    public function actionCreate()
    {
    	$requestData = Yii::$app->request->post();
    	$booking = new Booking();
    	return $booking->addBookingInfo($requestData);
    }
}
