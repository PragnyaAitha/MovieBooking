<?php

namespace app\controllers;

use Yii;
use yii\web\HttpException;
use yii\rest\ActiveController;
use app\models\Ticket;

class TicketController extends ActiveController
{
	public $modelClass = 'app\models\Ticket';
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBuyTickets($movie_id, $city_id){
    	$ticket = new Ticket();
    	$ticketData = $ticket->getTicketShowsAndCinemaHallData($movie_id, $city_id);

    	if(!empty($ticketData)){
    		return $ticketData;
    	}else{
    		throw new HttpException(404, Yii::t('app','Record not found.'));
    	}
    }

}
