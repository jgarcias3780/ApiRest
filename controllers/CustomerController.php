<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use app\models\Customer;

class CustomerController extends Controller
{
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Customer::find(),
        ]);
    }
    public function actionView($id)
    {
        return Customer::findOne($id);
    }
}
