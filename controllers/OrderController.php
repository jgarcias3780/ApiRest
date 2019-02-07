<?php

namespace app\controllers;

use app\models\Order;

class OrderController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionCreateorder() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $order = new Order();
        $order->scenario = Order::SCENARIO_CREATE;
        $order->attributes = \Yii::$app->request->post();

        if ($order->validate()) {
            $order->save();
            return array('status' => true, 'data' => 'Se genero al orden correctamente');
        } else {
            return array('status' => false, 'data' => $order->getErrors());
        }
    }

    public function actionListorder() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $order = new Order();
        $order->scenario = Order::SCENARIO_LIST;
        $order->attributes = \Yii::$app->request->post();
        if ($order->validate()) {

            if ($order->start_date != '' && $order->end_date != '') {
                $sql = "select * from test.order where customer_id = :customer_id and creation_date between :start_date and :end_date";
                $orderL = Order::findBySql($sql, array(':customer_id' => $order->customer_id, ':start_date' => $order->start_date, 'end_date' => $order->end_date))->all();
                if (count($orderL) > 0) {
                    return array('status' => true, 'data' => $orderL);
                } else {
                    return array('status' => false, 'data' => 'No existen ordenes en el rango de fechas');
                }
            } else {
                $error = array('start_date' => 'No puede estar vacio',
                    'end_date' => 'No puede estar vacio');
                return array('status' => false, 'data' => $error);
            }
        } else {
            return array('status' => false, 'data' => $order->getErrors());
        }
    }

}
