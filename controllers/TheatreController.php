<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\rest\ActiveController;
use app\models\Theatre;;

class TheatreController extends ActiveController{

	public $modelClass = 'app\models\Theatre'; //Theatre();
	public function actionSay($message = 'Hello'){
        return $this->render('say', ['message' => $message]);
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionCreate(){
    	$model = new Theatre();
    	if($model->load(Yii::$app->request->post(), 'theatre')){
    		$model->save();
    		return $model;
    	}
    }

    public function actionFetch(){
    	return Theatre::find()->all(); 
    }

    public function actionGetTheatre($id){
    	return Theatre::findOne(['id' => $id]);
    }

    public function actionUpdate($id){
    	$model = Theatre::findOne(['id' => $id]);
    	if($model->load(Yii::$app->request->post(), '')){
    		$model->save();
    		return $model;
    	}
    }

}