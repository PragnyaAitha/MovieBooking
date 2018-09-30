<?php

namespace app\controllers;

use yii\web\HttpException;
use yii\rest\ActiveController;
use app\models\CinemaHall;

class CinemaHallController extends ActiveController
{
	public $modelClass = 'app\models\CinemaHall';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSeatLayout($city_id, $movie_id, $cinema_hall_id, $show_time_id){
    	$cinemaHall = new CinemaHall();
    	$seatData = $cinemaHall->getUnbookedSeats($city_id, $movie_id, $cinema_hall_id, $show_time_id);

    	if(!empty($seatData)){
    		return $seatData;
    	}else{
    		throw new HttpException(404, Yii::t('app','Record not found.'));
    	}
    }	


}
