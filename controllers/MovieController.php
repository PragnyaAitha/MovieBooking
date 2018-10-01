<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Movie;
use yii\web\HttpException;

class MovieController extends ActiveController
{
	public $modelClass = 'app\models\Movie';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFetchActiveMovies($city_id){

    	$movie = new Movie();
    	$activeMovies = $movie->activeMovies($city_id);

    	if(!empty($activeMovies)){
    		return $activeMovies;
    	}else{
    		throw new HttpException(404, Yii::t('app','Record not found.'));
    	}
    }
}
